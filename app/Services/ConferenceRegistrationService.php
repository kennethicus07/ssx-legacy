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

    /**
     * --------------------------------------------------------------------------
     * Determine if the conference registration qualifies for Early Bird.
     *
     * IMPORTANT:
     * This uses the conference's created_at date, NOT today's date.
     *
     * This means:
     * - Registration created on/before Aug 31, 2026 = Early Bird rate
     * - Registration created after October 30, 2026 = Regular rate
     *
     * Adding/updating/deleting delegates later will NOT change the rate.
     * --------------------------------------------------------------------------
     */
    private function isEarlyBird(SSXConference $conference): bool
    {
        $deadline = Carbon::create(
            2026,
            10,
            31,
            23,
            59,
            59,
            'Asia/Manila'
        );

        $registrationDate = Carbon::parse(
            $conference->created_at
        )->setTimezone('Asia/Manila');

        return $registrationDate->lte($deadline);
    }

    /**
     * --------------------------------------------------------------------------
     * Remove and rebuild the Base breakdown.
     * --------------------------------------------------------------------------
     */
    private function rebuildBaseBreakdown(
        SSXConference $conference,
        int $participantCount,
        float $baseTotal
    ): void {
        /**
         * Remove existing Base row
         */
        $conference->conferenceBreakdown()
            ->where(
                'type',
                SSXConferenceBreakdown::TYPE_BASE
            )
            ->delete();

        /**
         * Create new Base row
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

    /**
     * --------------------------------------------------------------------------
     * Remove and rebuild automatic discounts.
     * --------------------------------------------------------------------------
     */
    private function rebuildAutomaticDiscounts(
        SSXConference $conference,
        float $baseRate
    ): void {
        /**
         * Remove existing automatic discounts
         */
        $conference->conferenceBreakdown()
            ->where('system_code', 'spc20')
            ->delete();

        /**
         * ----------------------------------------------------------------------
         * Eligible Delegates
         *
         * Visitor / Buyer delegates are excluded.
         * Speaker delegates are also excluded.
         *
         * They can still have Senior/PWD flags, but those flags do not
         * generate a registration discount when they are Visitor/Buyer
         * or Speaker.
         * ----------------------------------------------------------------------
         */
        $specialCount = $conference->conferenceDelegates()
            ->where('is_visitor_buyer', 0)
            ->where('is_speaker', 0)
            ->where(function ($query) {
                $query->whereIn('addtnl_type', [
                    'Government',
                    'AcademeStudent',
                ])
                ->orWhere('senior', 1)
                ->orWhere('pwd', 1);
            })
            ->count();

        /**
         * No eligible delegates = no automatic discount.
         */
        if ($specialCount == 0) {
            return;
        }

        /**
         * ----------------------------------------------------------------------
         * Discount Per Delegate
         *
         * IMPORTANT:
         * Early Bird is determined from the conference registration date,
         * NOT today's date.
         *
         * Therefore, if the registration was created during Early Bird,
         * its discount remains based on the Early Bird rate even if an admin
         * adds a delegate after respected date
         * ----------------------------------------------------------------------
         */
        $isForeign = $conference->business_type === 'foreign';

        $isEarlyBird = $this->isEarlyBird($conference);

        if ($isEarlyBird) {
            /**
             * Early Bird discount:
             * 20% of the applicable base rate.
             */
            $discountPerDelegate = $baseRate * 0.20;
        } else {
            /**
             * Regular registration discount.
             */
            $discountPerDelegate = $isForeign
                ? 54
                : 2000;
        }

        /**
         * Create automatic discount.
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

    /**
     * --------------------------------------------------------------------------
     * Calculate registration totals from the breakdown records.
     * --------------------------------------------------------------------------
     */
    private function calculateTotals(
        SSXConference $conference
    ): array {
        $breakdowns = $conference
            ->conferenceBreakdown()
            ->get();

        /**
         * Base
         */
        $baseTotal = $breakdowns
            ->where(
                'type',
                SSXConferenceBreakdown::TYPE_BASE
            )
            ->sum('value');

        /**
         * Admin Added Fees
         */
        $additionalFees = $breakdowns
            ->where(
                'type',
                SSXConferenceBreakdown::TYPE_ADD_FEE
            )
            ->sum('value');

        /**
         * Discounts
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

        /**
         * Amount before discounts
         */
        $amount = $baseTotal + $additionalFees;

        /**
         * Final amount
         */
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

    /**
     * --------------------------------------------------------------------------
     * Update the conference totals.
     * --------------------------------------------------------------------------
     */
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

        /**
         * Only count actual paid participants.
         *
         * Excluded:
         * - Visitor / Buyer
         * - Speaker
         */
        $conference->participant_count =
            $conference
                ->conferenceDelegates()
                ->where('is_visitor_buyer', 0)
                ->where('is_speaker', 0)
                ->count();

        $conference->save();
    }

    /**
     * --------------------------------------------------------------------------
     * Recompute the registration pricing.
     * --------------------------------------------------------------------------
     */
    public function recompute(SSXConference $conference): array
    {
        /**
         * ----------------------------------------------------------------------
         * Base Rate
         *
         * The rate is determined from the conference registration date.
         * ----------------------------------------------------------------------
         */
        $baseRate = $this->getBaseRate($conference);

        /**
         * ----------------------------------------------------------------------
         * Paid Delegates
         *
         * Visitor / Buyer delegates are NOT included.
         * Speaker delegates are NOT included.
         * ----------------------------------------------------------------------
         */
        $participantCount = $conference
            ->conferenceDelegates()
            ->where('is_visitor_buyer', 0)
            ->where('is_speaker', 0)
            ->count();

        /**
         * ----------------------------------------------------------------------
         * Base Total
         * ----------------------------------------------------------------------
         */
        $baseTotal = $participantCount * $baseRate;

        /**
         * ----------------------------------------------------------------------
         * Rebuild Base
         * ----------------------------------------------------------------------
         */
        $this->rebuildBaseBreakdown(
            $conference,
            $participantCount,
            $baseTotal
        );

        /**
         * ----------------------------------------------------------------------
         * Rebuild Automatic Discounts
         *
         * Visitor / Buyer and Speaker delegates are excluded.
         * ----------------------------------------------------------------------
         */
        $this->rebuildAutomaticDiscounts(
            $conference,
            $baseRate
        );

        /**
         * ----------------------------------------------------------------------
         * Calculate Totals
         * ----------------------------------------------------------------------
         */
        $totals = $this->calculateTotals(
            $conference
        );

        /**
         * ----------------------------------------------------------------------
         * Update Conference
         * ----------------------------------------------------------------------
         */
        $this->updateConferenceTotals(
            $conference,
            $totals
        );

        /**
         * ----------------------------------------------------------------------
         * Return Results
         * ----------------------------------------------------------------------
         */
        return array_merge(
            [
                'base_rate' => $baseRate,

                'participant_count' => $participantCount,

                'total_delegates' => $conference
                    ->conferenceDelegates()
                    ->count(),

                'speaker_count' => $conference
                    ->conferenceDelegates()
                    ->where('is_speaker', 1)
                    ->count(),

                'visitor_buyer_count' => $conference
                    ->conferenceDelegates()
                    ->where('is_visitor_buyer', 1)
                    ->count(),
            ],
            $totals
        );
    }

    /**
     * --------------------------------------------------------------------------
     * Determine the base registration rate.
     *
     * Foreign:
     * - Early Bird: $60
     * - Regular: $150
     *
     * Local:
     * - Early Bird: ₱2,500
     * - Regular: ₱6,000
     *
     * IMPORTANT:
     * The Early Bird determination is based on the conference's
     * created_at date, NOT today's date.
     * --------------------------------------------------------------------------
     */
    // public function getBaseRate(SSXConference $conference): float
    // {
    //     $isEarlyBird = $this->isEarlyBird($conference);

    //     /**
    //      * Foreign registration
    //      */
    //     if ($conference->business_type === 'foreign') {
    //         return $isEarlyBird
    //             ? 60
    //             : 150;
    //     }

    //     /**
    //      * Local registration
    //      */
    //     return $isEarlyBird
    //         ? 2500
    //         : 6000;
    // }

        
    public function getBaseRate(SSXConference $conference): float
    {
        $isEarlyBird = $this->isEarlyBird($conference);

        /**
         * Foreign registration
         */
        if ($conference->business_type === 'foreign') {
            return $isEarlyBird
                ? 60
                : 60;
        }

        /**
         * Local registration
         */
        return $isEarlyBird
            ? 2500
            : 2500;
    }
}