<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SSXConference;
use App\Models\SSXConferenceSoa;
use App\Models\SSXConferenceBreakdown;
use Barryvdh\DomPDF\Facade\Pdf;

class ConferenceSoaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PRIVATE - TEMPORARY VAT PROCESSING
    |--------------------------------------------------------------------------
    |
    | VAT processing is intentionally isolated here.
    |
    | If VAT is no longer needed later, you can remove this method
    | and remove the call from generateSoaBilling().
    |
    */

    private function processVat(
        Request $request,
        SSXConferenceSoa $soa,
        float $finalAmount
    ): array {

        /*
        |--------------------------------------------------------------------------
        | VAT RATE
        |--------------------------------------------------------------------------
        |
        | Default VAT rate is 12%.
        |
        */

        $vatRate = 12.00;

        /*
        |--------------------------------------------------------------------------
        | VAT OPTIONS
        |--------------------------------------------------------------------------
        */

        $vatExempted = $request->boolean(
            'vat_exempted'
        );

        $vatZeroExempted = $request->boolean(
            'vat_zero_exempted'
        );

        /*
        |--------------------------------------------------------------------------
        | VAT CALCULATION
        |--------------------------------------------------------------------------
        |
        | The conference final_amount is treated as VAT-inclusive.
        |
        | Example:
        |
        | Total Amount Due = 112,000
        |
        | VAT = 112,000 - (112,000 / 1.12)
        | VAT = 12,000
        |
        | Net of VAT = 100,000
        |
        */

        if ($vatExempted || $vatZeroExempted) {

            $vatAmount = 0.00;

            $netVat = $finalAmount;

        } else {

            $vatAmount =
                $finalAmount -
                ($finalAmount * (100 / (100 + $vatRate)));

            $netVat =
                $finalAmount -
                $vatAmount;
        }

        /*
        |--------------------------------------------------------------------------
        | Save VAT information to SOA
        |--------------------------------------------------------------------------
        */

        $soa->vat_rate =
            $vatRate;

        $soa->vat_exempted =
            $vatExempted;

        $soa->vat_zero_exempted =
            $vatZeroExempted;

        return [
            'vat_rate' =>
                $vatRate,

            'vat_amount' =>
                round($vatAmount, 2),

            'net_vat' =>
                round($netVat, 2),

            'total_amount_due' =>
                round($finalAmount, 2),

            'vat_exempted' =>
                $vatExempted,

            'vat_zero_exempted' =>
                $vatZeroExempted,
        ];
    }


    /**
     * Generate SOA / Billing Statement
     *
     * Uses the pricing already saved on the conference
     * registration and conference breakdown.
     *
     * Does NOT recalculate today's registration rate.
     */
    public function generateSoaBilling(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'date_issued' => [
                'required',
                'date',
            ],

            /*
             * NULL = IMMEDIATELY
             */
            'date_due' => [
                'nullable',
                'date',
            ],

            /*
             * VAT is OPTIONAL.
             */

            'vat_exempted' => [
                'nullable',
                'boolean',
            ],

            'vat_zero_exempted' => [
                'nullable',
                'boolean',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Conference
        |--------------------------------------------------------------------------
        */

        $conference = SSXConference::with([
            'conferenceDelegates',
            'conferenceBreakdown',
            'conferenceKnowhow',
            'conferenceSoa',
            'event'
        ])->find($id);

        if (!$conference) {

            return response()->json([
                'message' =>
                    'Conference not found.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Base Breakdown
        |--------------------------------------------------------------------------
        */

        $baseBreakdown = $conference
            ->conferenceBreakdown
            ->where(
                'type',
                SSXConferenceBreakdown::TYPE_BASE
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Base Rate
        |--------------------------------------------------------------------------
        |
        | Use the rate already saved on registration.
        |
        */

        $baseRate =
            (float) $conference->base_rate;


        /*
        |--------------------------------------------------------------------------
        | Participant Count
        |--------------------------------------------------------------------------
        */

        $participantCount =
            $baseBreakdown
                ? (int) $baseBreakdown->count
                : $conference
                    ->conferenceDelegates
                    ->where(
                        'is_visitor_buyer',
                        0
                    )
                    ->count();


        /*
        |--------------------------------------------------------------------------
        | Base Total
        |--------------------------------------------------------------------------
        */

        $baseTotal =
            $baseBreakdown
                ? (float) $baseBreakdown->value
                : (
                    $baseRate *
                    $participantCount
                );


        /*
        |--------------------------------------------------------------------------
        | Additional Fees
        |--------------------------------------------------------------------------
        */

        $fees = $conference
            ->conferenceBreakdown
            ->filter(function ($item) {

                return $item->type ===
                    SSXConferenceBreakdown::TYPE_ADD_FEE;
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Discounts
        |--------------------------------------------------------------------------
        */

        $discounts = $conference
            ->conferenceBreakdown
            ->filter(function ($item) {

                return in_array(
                    $item->type,
                    [
                        SSXConferenceBreakdown::TYPE_DISCOUNT,
                        SSXConferenceBreakdown::TYPE_ADD_DISCOUNT,
                    ]
                );
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Fee Total
        |--------------------------------------------------------------------------
        */

        $feeTotal =
            $fees->sum(function ($item) {

                return (float) $item->value;
            });


        /*
        |--------------------------------------------------------------------------
        | Total Amount Before Deductions
        |--------------------------------------------------------------------------
        |
        | Base Registration
        | +
        | Additional Fees
        |
        */

        $totalBeforeDeductions =
            $baseTotal +
            $feeTotal;


        /*
        |--------------------------------------------------------------------------
        | Discount Total
        |--------------------------------------------------------------------------
        */

        $discountTotal =
            $discounts->sum(function ($item) {

                return (float) $item->value;
            });


        /*
        |--------------------------------------------------------------------------
        | Final Amount
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Use the final amount already saved on the registration.
        |
        | Do NOT recalculate registration pricing here.
        |
        */

        $finalAmount =
            (float) $conference->final_amount;


        /*
        |--------------------------------------------------------------------------
        | Create SOA
        |--------------------------------------------------------------------------
        */

        $timestamp =
            now()->format('Ymd_His');

        $fileName =
            $conference->registration_number .
            '_soa_' .
            $timestamp .
            '.pdf';


        $soa = new SSXConferenceSoa();

        $soa->ssx_conference_id =
            $conference->id;

        $soa->fair_code =
            $conference->fair_code;

        $soa->soa_file =
            $fileName;

        $soa->date_issued =
            $validated['date_issued'];

        /*
         * NULL = IMMEDIATELY
         */
        $soa->date_due =
            $validated['date_due'] ?? null;



        $soa->created_by =
            Auth::id();

        $soa->updated_by =
            Auth::id();


        /*
        |--------------------------------------------------------------------------
        | PRIVATE VAT PROCESSING
        |--------------------------------------------------------------------------
        |
        | VAT is optional.
        |
        | If the method is called:
        | - Default VAT = 12%
        | - VAT exemption = 0 VAT
        | - VAT zero-rated = 0 VAT
        |
        | If you later remove this call, the SOA generation itself
        | will continue to work.
        |
        */

        $vat = $this->processVat(
            $request,
            $soa,
            $finalAmount
        );


        /*
        |--------------------------------------------------------------------------
        | Save SOA
        |--------------------------------------------------------------------------
        */

        $soa->save();


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        try {

            Pdf::loadView(
                'emails.conference.conference-billing',
                [

                    /*
                     * Conference
                     */
                    'conf' =>
                        $conference,

                    'event' =>
            $conference->event,

                    /*
                     * SOA
                     */
                    'soa' =>
                        $soa,

                    /*
                     * Base
                     */
                    'base_rate' =>
                        $baseRate,

                    'participant_count' =>
                        $participantCount,

                    'base_total' =>
                        $baseTotal,

                    /*
                     * Fees
                     */
                    'fees' =>
                        $fees,

                    'fee_total' =>
                        $feeTotal,

                    /*
                     * Total Before Deductions
                     */
                    'total_before_deductions' =>
                        $totalBeforeDeductions,

                    /*
                     * Discounts
                     */
                    'discounts' =>
                        $discounts,

                    'discount_total' =>
                        $discountTotal,

                    /*
                     * Final Amount
                     */
                    'final_amount' =>
                        $finalAmount,

                    /*
                     |--------------------------------------------------------------------------
                     | VAT
                     |--------------------------------------------------------------------------
                     */

                    'vat_rate' =>
                        $vat['vat_rate'],

                    'vat_amount' =>
                        $vat['vat_amount'],

                    'net_vat' =>
                        $vat['net_vat'],

                    'total_amount_due' =>
                        $vat['total_amount_due'],

                    'vat_exempted' =>
                        $vat['vat_exempted'],

                    'vat_zero_exempted' =>
                        $vat['vat_zero_exempted'],
                ]
            )
            ->setPaper(
                'a4',
                'portrait'
            )
            ->save(
                'conference/billing/' .
                $fileName
            );

             $conference->billing_status =
        SSXConference::BILLING_GENERATED;

    $conference->save();

        } catch (\Throwable $e) {

            /*
             |--------------------------------------------------------------------------
             | PDF failed
             |--------------------------------------------------------------------------
             |
             | Remove SOA record because there is no PDF.
             |
             */

            $soa->delete();

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'message' =>
                'SOA / Billing Statement generated successfully.',

            'soa' => [

                'id' =>
                    $soa->id,

                'ssx_conference_id' =>
                    $soa->ssx_conference_id,

                'fair_code' =>
                    $soa->fair_code,

                'soa_file' =>
                    $soa->soa_file,


                /*
                 * Pricing
                 */

                'participant_count' =>
                    $participantCount,

                'base_rate' =>
                    $baseRate,

                'base_total' =>
                    $baseTotal,

                'fee_total' =>
                    $feeTotal,

                'total_before_deductions' =>
                    $totalBeforeDeductions,

                'discount_total' =>
                    $discountTotal,

                'final_amount' =>
                    $finalAmount,


                /*
                 * VAT
                 */

                'vat_rate' =>
                    $vat['vat_rate'],

                'vat_amount' =>
                    $vat['vat_amount'],

                'net_vat' =>
                    $vat['net_vat'],

                'total_amount_due' =>
                    $vat['total_amount_due'],

                'vat_exempted' =>
                    $vat['vat_exempted'],

                'vat_zero_exempted' =>
                    $vat['vat_zero_exempted'],


                /*
                 * Dates
                 */

                'date_issued' =>
                    optional(
                        $soa->date_issued
                    )->format(
                        'Y-m-d'
                    ),

                'date_due' =>
                    optional(
                        $soa->date_due
                    )->format(
                        'Y-m-d'
                    ),


                /*
                 * Status
                 */

                'status' =>
                    $soa->status,


                /*
                 * Users
                 */

                'created_by' =>
                    $soa->created_by,

                'updated_by' =>
                    $soa->updated_by,


                /*
                 * Timestamps
                 */

                'created_at' =>
                    optional(
                        $soa->created_at
                    )->format(
                        'Y-m-d H:i:s'
                    ),

                'updated_at' =>
                    optional(
                        $soa->updated_at
                    )->format(
                        'Y-m-d H:i:s'
                    ),
            ],


            /*
             * PDF
             */

            'soa_file' =>
                $fileName,

            'soa_url' =>
                url(
                    'conference/billing/' .
                    $fileName
                ),

        ], 200);
    }

    public function submitForApproval($id)
{
    $conference = SSXConference::find($id);

    if (!$conference) {
        return response()->json([
            'message' => 'Conference not found.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Billing Status
    |--------------------------------------------------------------------------
    |
    | Only generated SOA/Billing can be submitted for approval.
    |
    */

    if ((int) $conference->billing_status !== SSXConference::BILLING_GENERATED) {
        return response()->json([
            'message' => 'Only generated SOA/Billing can be submitted for approval.',
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | Submit for Approval
    |--------------------------------------------------------------------------
    */

    $conference->billing_status =
        SSXConference::BILLING_FOR_APPROVAL;

    $conference->save();

    return response()->json([
        'message' => 'SOA / Billing submitted for approval successfully.',
        'billing_status' => $conference->billing_status,
    ], 200);
}

public function returnToGenerated($id)
{
    $conference = SSXConference::find($id);

    if (!$conference) {
        return response()->json([
            'message' => 'Conference not found.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Billing Status
    |--------------------------------------------------------------------------
    */

    if ((int) $conference->billing_status !== SSXConference::BILLING_FOR_APPROVAL) {
        return response()->json([
            'message' => 'Only billing submitted for approval can be returned.',
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Latest SOA
    |--------------------------------------------------------------------------
    */

    $soa = SSXConferenceSoa::where(
        'ssx_conference_id',
        $conference->id
    )
    ->latest('id')
    ->first();

    /*
    |--------------------------------------------------------------------------
    | Reject SOA
    |--------------------------------------------------------------------------
    */

    if ($soa) {
        $soa->status = SSXConferenceSoa::STATUS_REJECTED;
        $soa->updated_by = Auth::id();
        $soa->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Return Billing to Generated
    |--------------------------------------------------------------------------
    */

    $conference->billing_status =
        SSXConference::BILLING_GENERATED;

    $conference->save();

    return response()->json([
        'message' =>
            'SOA / Billing returned to generated status successfully.',

        'billing_status' =>
            $conference->billing_status,

        'soa_status' =>
            $soa ? $soa->status : null,
    ], 200);
}


public function approveBilling($id)
{
    $conference = SSXConference::find($id);

    if (!$conference) {
        return response()->json([
            'message' => 'Conference not found.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Billing Status
    |--------------------------------------------------------------------------
    */

    if ((int) $conference->billing_status !== SSXConference::BILLING_FOR_APPROVAL) {
        return response()->json([
            'message' => 'Only billing submitted for approval can be approved.',
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Latest SOA
    |--------------------------------------------------------------------------
    */

    $soa = SSXConferenceSoa::where(
        'ssx_conference_id',
        $conference->id
    )
    ->latest('id')
    ->first();

    /*
    |--------------------------------------------------------------------------
    | Approve SOA
    |--------------------------------------------------------------------------
    */

if ($soa) {
    $soa->status = SSXConferenceSoa::STATUS_APPROVED;
    $soa->updated_by = Auth::id();
    $soa->save();

    // Store the approved SOA file as the conference billing file
    $conference->billing_file = $soa->soa_file;
}

    /*
    |--------------------------------------------------------------------------
    | Approve Billing
    |--------------------------------------------------------------------------
    */

    $conference->billing_status =
        SSXConference::BILLING_APPROVED;

    $conference->save();

    return response()->json([
        'message' =>
            'SOA / Billing approved successfully.',

        'billing_status' =>
            $conference->billing_status,

        'soa_status' =>
            $soa ? $soa->status : null,
    ], 200);
}

    /**
     * Get the latest SOA for a conference.
     */
    public function show($conf_id)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Conference
        |--------------------------------------------------------------------------
        */

        $conference =
            SSXConference::find(
                $conf_id
            );

        if (!$conference) {

            return response()->json([
                'message' =>
                    'Conference not found.',
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | Get Latest SOA
        |--------------------------------------------------------------------------
        */

        $soa =
            SSXConferenceSoa::where(
                'ssx_conference_id',
                $conference->id
            )
            ->latest('id')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | No SOA Yet
        |--------------------------------------------------------------------------
        */

        if (!$soa) {

            return response()->json([
                'generated' =>
                    false,

                'soa' =>
                    null,
            ], 200);
        }


        /*
        |--------------------------------------------------------------------------
        | SOA Data
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'generated' =>
                true,

            'soa' => [

                'id' =>
                    $soa->id,

                'ssx_conference_id' =>
                    $soa->ssx_conference_id,

                'fair_code' =>
                    $soa->fair_code,

                'soa_file' =>
                    $soa->soa_file,

                'soa_url' =>
                    url(
                        'conference/billing/' .
                        $soa->soa_file
                    ),


                /*
                 * Dates
                 */

                'date_issued' =>
                    optional(
                        $soa->date_issued
                    )->format(
                        'Y-m-d'
                    ),

                'date_due' =>
                    optional(
                        $soa->date_due
                    )->format(
                        'Y-m-d'
                    ),


                /*
                 * VAT
                 */

                'vat_rate' =>
                    $soa->vat_rate,

                'vat_exempted' =>
                    $soa->vat_exempted,

                'vat_zero_exempted' =>
                    $soa->vat_zero_exempted,


                /*
                 * Status
                 */

                'status' =>
                    $soa->status,


                /*
                 * Users
                 */

                'created_by' =>
                    $soa->created_by,

                'updated_by' =>
                    $soa->updated_by,


                /*
                 * Timestamps
                 */

                'created_at' =>
                    optional(
                        $soa->created_at
                    )->format(
                        'Y-m-d H:i:s'
                    ),

                'updated_at' =>
                    optional(
                        $soa->updated_at
                    )->format(
                        'Y-m-d H:i:s'
                    ),
            ],
        ], 200);
    }
}