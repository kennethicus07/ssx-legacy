<?php

namespace App\Services;

use App\Models\SSXConference;
use App\Models\SSXConferenceBreakdown;
use Illuminate\Support\Carbon;

class ConferenceRegistrationService
{
    /**
     * Recompute the registration pricing.
     */

private function rebuildBaseBreakdown(
    SSXConference $conference,
    int $participantCount,
    float $baseTotal
): void {

    /*
    |--------------------------------------------------------------------------
    | Remove existing Base row
    |--------------------------------------------------------------------------
    */

    $conference->conferenceBreakdown()
        ->where('type', SSXConferenceBreakdown::TYPE_BASE)
        ->delete();

    /*
    |--------------------------------------------------------------------------
    | Create new Base row
    |--------------------------------------------------------------------------
    */

    $conference->conferenceBreakdown()->create([
        'code' => null,
        'system_code' => null,
        'type' => SSXConferenceBreakdown::TYPE_BASE,
        'count' => 0,
        'value' => $baseTotal,
        'description' => "{$participantCount} x Delegates",
    ]);
}

// private function rebuildAutomaticDiscounts(
//     SSXConference $conference,
//     float $baseRate
// ): void {

//     /*
//     |--------------------------------------------------------------------------
//     | Remove existing automatic discounts
//     |--------------------------------------------------------------------------
//     */

//     $conference->conferenceBreakdown()
//         ->where('system_code', 'spc20')
//         ->delete();

// /*
// |--------------------------------------------------------------------------
// | Eligible Delegates
// |--------------------------------------------------------------------------
// */

// $specialCount = $conference->conferenceDelegates()
//     ->where(function ($query) {

//         $query->whereIn('addtnl_type', [
//             'Government',
//             'AcademeStudent'
//         ])
//         ->orWhere('senior', 1)
//         ->orWhere('pwd', 1);

//     })
//     ->count();

//     if ($specialCount == 0) {
//     return;
// }
// /*
// |--------------------------------------------------------------------------
// | Discount Per Delegate
// |--------------------------------------------------------------------------
// */

// $discountPerDelegate = 0;

// $isForeign = $conference->business_type === 'foreign';

// $deadline = \Carbon\Carbon::create(2026, 8, 31);

// $today = \Carbon\Carbon::now('Asia/Manila')->startOfDay();

// $isEarlyBird = $today->lte($deadline);

// if ($isEarlyBird) {

//     $discountPerDelegate = $isForeign
//         ? ($baseRate * 0.20)
//         : ($baseRate * 0.20);

// } else {

//     $discountPerDelegate = $isForeign
//         ? 54
//         : 2000;
// }
// $conference->conferenceBreakdown()->create([

//     'code' => null,

//     'system_code' => 'spc20',

//     'type' => SSXConferenceBreakdown::TYPE_DISCOUNT,

//     'count' => $specialCount,

//     'value' => $discountPerDelegate * $specialCount,

//     'description' => 'Government, Academe, Students, Senior Citizens, PWDs Discount',

// ]);
// }
private function rebuildAutomaticDiscounts(
    SSXConference $conference,
    float $baseRate
): void {

    /*
    |--------------------------------------------------------------------------
    | Remove existing automatic discounts
    |--------------------------------------------------------------------------
    */

    $conference->conferenceBreakdown()
        ->where('system_code', 'spc20')
        ->delete();

    /*
    |--------------------------------------------------------------------------
    | Eligible Delegates
    |
    | Visitor / Buyer delegates are excluded from the computation.
    | They can still be Senior/PWD, but those flags do not generate
    | a registration discount when they are Visitor/Buyer.
    |--------------------------------------------------------------------------
    */

    $specialCount = $conference->conferenceDelegates()
        ->where('is_visitor_buyer', 0)
        ->where(function ($query) {

            $query->whereIn('addtnl_type', [
                'Government',
                'AcademeStudent'
            ])
            ->orWhere('senior', 1)
            ->orWhere('pwd', 1);

        })
        ->count();

    if ($specialCount == 0) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Discount Per Delegate
    |--------------------------------------------------------------------------
    */

    $isForeign = $conference->business_type === 'foreign';

    $deadline = Carbon::create(2026, 8, 31);

    $today = Carbon::now('Asia/Manila')->startOfDay();

    $isEarlyBird = $today->lte($deadline);

    if ($isEarlyBird) {

        $discountPerDelegate = $baseRate * 0.20;

    } else {

        $discountPerDelegate = $isForeign
            ? 54
            : 2000;
    }

    /*
    |--------------------------------------------------------------------------
    | Create Automatic Discount
    |--------------------------------------------------------------------------
    */

    $conference->conferenceBreakdown()->create([

        'code' => null,

        'system_code' => 'spc20',

        'type' => SSXConferenceBreakdown::TYPE_DISCOUNT,

        'count' => $specialCount,

        'value' => $discountPerDelegate * $specialCount,

        'description' =>
            'Government, Academe, Students, Senior Citizens, PWDs Discount',

    ]);
}

private function calculateTotals(
    SSXConference $conference
): array {

    $breakdowns = $conference
        ->conferenceBreakdown()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Base
    |--------------------------------------------------------------------------
    */

    $baseTotal = $breakdowns
        ->where(
            'type',
            SSXConferenceBreakdown::TYPE_BASE
        )
        ->sum('value');


    /*
    |--------------------------------------------------------------------------
    | Admin Added Fees
    |--------------------------------------------------------------------------
    */

    $additionalFees = $breakdowns
        ->where(
            'type',
            SSXConferenceBreakdown::TYPE_ADD_FEE
        )
        ->sum('value');


    /*
    |--------------------------------------------------------------------------
    | Discounts
    |--------------------------------------------------------------------------
    */

    $discounts = $breakdowns
        ->whereIn(
            'type',
            [
                SSXConferenceBreakdown::TYPE_DISCOUNT,
                SSXConferenceBreakdown::TYPE_ADD_DISCOUNT,
            ]
        )
        ->sum('value');


    /*
    |--------------------------------------------------------------------------
    | Final
    |--------------------------------------------------------------------------
    */

    $amount = $baseTotal + $additionalFees;


    $finalAmount = max(
        0,
        $amount - $discounts
    );


    return [

        'base_total' => $baseTotal,

        'additional_fees' => $additionalFees,

        'discounts' => $discounts,

        'amount' => $amount,

        'final_amount' => $finalAmount,

    ];
}

private function updateConferenceTotals(
    SSXConference $conference,
    array $totals
): void {

    $conference->amount =
        $totals['amount'];

    $conference->discount =
        $totals['discounts'];

    $conference->final_amount =
        $totals['final_amount'];

    $conference->participant_count =
        $conference
            ->conferenceDelegates()
            ->count();


    $conference->save();
}



// public function recompute(SSXConference $conference): array
// {

//     /*
//     |--------------------------------------------------------------------------
//     | Base Rate
//     |--------------------------------------------------------------------------
//     */

//     $baseRate = $this->getBaseRate($conference);


//     /*
//     |--------------------------------------------------------------------------
//     | Delegates
//     |--------------------------------------------------------------------------
//     */

// $participantCount = $conference
//     ->conferenceDelegates()
//     ->where('is_visitor_buyer', 0)
//     ->count();

// $baseTotal = $participantCount * $baseRate;



//     /*
//     |--------------------------------------------------------------------------
//     | Rebuild Base
//     |--------------------------------------------------------------------------
//     */

//     $this->rebuildBaseBreakdown(
//         $conference,
//         $participantCount,
//         $baseTotal
//     );



//     /*
//     |--------------------------------------------------------------------------
//     | Rebuild System Discounts
//     |--------------------------------------------------------------------------
//     */

//     $this->rebuildAutomaticDiscounts(
//         $conference,
//         $baseRate
//     );



//     /*
//     |--------------------------------------------------------------------------
//     | Calculate Totals
//     |--------------------------------------------------------------------------
//     */

//     $totals = $this->calculateTotals(
//         $conference
//     );



//     /*
//     |--------------------------------------------------------------------------
//     | Update Conference
//     |--------------------------------------------------------------------------
//     */

//     $this->updateConferenceTotals(
//         $conference,
//         $totals
//     );



//     return array_merge(
//         [
//             'base_rate' => $baseRate,
//             'participant_count' => $participantCount,
//         ],
//         $totals
//     );
// }

    /**
     * Determine the base rate based on registration type.
     */
    public function recompute(SSXConference $conference): array
{
    /*
    |--------------------------------------------------------------------------
    | Base Rate
    |--------------------------------------------------------------------------
    */

    $baseRate = $this->getBaseRate($conference);


    /*
    |--------------------------------------------------------------------------
    | Paid Delegates
    |
    | Visitor / Buyer delegates are NOT included in registration pricing.
    |--------------------------------------------------------------------------
    */

    $participantCount = $conference
        ->conferenceDelegates()
        ->where('is_visitor_buyer', 0)
        ->count();


    /*
    |--------------------------------------------------------------------------
    | Base Total
    |--------------------------------------------------------------------------
    */

    $baseTotal = $participantCount * $baseRate;


    /*
    |--------------------------------------------------------------------------
    | Rebuild Base
    |--------------------------------------------------------------------------
    */

    $this->rebuildBaseBreakdown(
        $conference,
        $participantCount,
        $baseTotal
    );


    /*
    |--------------------------------------------------------------------------
    | Rebuild System Discounts
    |
    | Visitor / Buyer delegates are also excluded from discounts.
    |--------------------------------------------------------------------------
    */

    $this->rebuildAutomaticDiscounts(
        $conference,
        $baseRate
    );


    /*
    |--------------------------------------------------------------------------
    | Calculate Totals
    |--------------------------------------------------------------------------
    */

    $totals = $this->calculateTotals(
        $conference
    );


    /*
    |--------------------------------------------------------------------------
    | Update Conference
    |--------------------------------------------------------------------------
    */

    $this->updateConferenceTotals(
        $conference,
        $totals
    );


    return array_merge(
        [
            'base_rate' => $baseRate,

            // Number of delegates being charged
            'participant_count' => $participantCount,

            // Actual registered delegates
            'total_delegates' => $conference
                ->conferenceDelegates()
                ->count(),

            // Visitor / Buyer delegates
            'visitor_buyer_count' => $conference
                ->conferenceDelegates()
                ->where('is_visitor_buyer', 1)
                ->count(),
        ],
        $totals
    );
}
    
    public function getBaseRate(SSXConference $conference): float
    {
        $deadline = Carbon::create(2026, 8, 31);

        $today = Carbon::now('Asia/Manila')->startOfDay();

        $isEarlyBird = $today->lte($deadline);

        if ($conference->business_type === 'foreign') {
            return $isEarlyBird ? 60 : 150;
        }

        return $isEarlyBird ? 2500 : 6000;
    }
}