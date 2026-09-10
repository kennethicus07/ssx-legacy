<?php

namespace App\Models\Supplier;

use App\Models\Conforme;
use App\Models\Exhibitor;
use App\Models\User;
use App\Models\UserAgreement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorAttendance extends Model
{
    use HasFactory;

    protected $table = 'exhibitor_attendance';

    protected $fillable = [
        'fair_code',
        'user_id',
   
        'conference_response',
        'sponsorship_response',
        'participation_type',
        'is_rtb_generated',
        'registration_agreement_id',
        'registration_agreement_status',
        'registration_agreement_agreed_at',
        'soa_agreement_id',
        'soa_agreement_status',
        'soa_agreement_agreed_at',
        'privacy_policy_id',
        'privacy_policy_status',
        'privacy_policy_agreed_at',
        'information_sharing_id',
        'information_sharing_status',
        'information_sharing_agreed_at',
        'conforme_review_date',
        'conforme_review',
        'conforme_by',
        'soa_by',
        'is_soa_generated',
        'soa_at',
        'payment_status',
        'payment_review_by',
        'payment_review_date',
        'status',

       


    ];

    protected $casts = [
        'is_rtb_generated' => 'boolean',
        'is_soa_generated' => 'boolean',
        'soa_at' => 'datetime',
        'payment_review_date' => 'datetime',
    ];

    // --- Status constants ---
    const STATUS_INCOMPLETE = 0;
    const STATUS_PENDING_CONFORME_GENERATION = 1;
    const STATUS_PENDING = 2;
    const STATUS_REVIEWED = 3;
    const STATUS_ONHOLD = 4;
    const STATUS_DENIED = 5;
    const SOA_NOT_GENERATED = 0;
    const SOA_GENERATED = 1;

    const PAYMENT_UNPAID = 0;
    const PAYMENT_PAID = 1;
    const PAYMENT_PENDING = 2;




    // --- Labels ---
    const LABEL_INCOMPLETE = 'Incomplete';
    const LABEL_PENDING_CONFORME_GENERATION = 'Pending Conforme Generation';
    const LABEL_AWAITING_CONFORME = 'Awaiting Conforme Response'; 
    const LABEL_PENDING = 'Pending';
    const LABEL_REVIEWED = 'Reviewed';
    const LABEL_ONHOLD = 'Onhold';
    const LABEL_DENIED = 'Denied';
    const LABEL_READY_FOR_RTB = 'For RTB';
    const LABEL_GENERATED_RTB = 'Generated RTB'; 
    const LABEL_SOA_NOT_GENERATED = 'SOA Not Generated';
    const LABEL_SOA_GENERATED = 'SOA Generated';
    const LABEL_PAYMENT_UNPAID = 'Unpaid';
    const LABEL_PAYMENT_PAID = 'Paid';
    const LABEL_PAYMENT_PENDING = 'Pending';



    // --- Relationships ---

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

        public function payment_reviewer()
    {
        return $this->belongsTo(User::class, 'payment_review_by', 'id');
    }


    public function conforme_officer()
    {
        return $this->belongsTo(User::class, 'conforme_by', 'id');
    }

    public function conformes()
    {
        return $this->hasMany(Conforme::class, 'ff_code', 'user_id')
                    ->where('fair_code', $this->fair_code);
    }

    public function latestConforme()
    {
        return $this->hasOne(Conforme::class, 'ff_code', 'user_id')
                    ->where('fair_code', $this->fair_code)
                    ->latest('created_at');
    }

    public function rtbGenerated()
    {
    return $this->hasMany(RtbGenerated::class, 'ff_code', 'user_id')
                ->where('fair_code', $this->fair_code);
    }

public function latestRtb()
{
    return $this->hasOne(RtbGenerated::class, 'ff_code', 'user_id')
                ->where('fair_code', $this->fair_code)
                ->latest('created_at');
}


    public function registrationAgreement()
    {
        return $this->belongsTo(UserAgreement::class, 'registration_agreement_id', 'id')
                    ->where('status', 1);
    }

    public function soaAgreement()
    {
        return $this->belongsTo(UserAgreement::class, 'soa_agreement_id', 'id')
                    ->where('status', 1);
    }

    public function privacyPolicy()
    {
        return $this->belongsTo(UserAgreement::class, 'privacy_policy_id', 'id')
                    ->where('status', 1);
    }

    public function informationSharing()
    {
        return $this->belongsTo(UserAgreement::class, 'information_sharing_id', 'id')
                    ->where('status', 1);
    }

    public function getAgreementsAttribute()
    {
        $map = [
            'registration' => [
                'relation' => 'registrationAgreement',
                'status' => 'registration_agreement_status',
            ],
            'soa' => [
                'relation' => 'soaAgreement',
                'status' => 'soa_agreement_status',
            ],
            'privacy_policy' => [
                'relation' => 'privacyPolicy',
                'status' => 'privacy_policy_status',
            ],
            'information_sharing' => [
                'relation' => 'informationSharing',
                'status' => 'information_sharing_status',
            ],
        ];

        return collect($map)->map(function ($config, $type) {
            $agreement = $this->{$config['relation']};

            if (!$agreement) {
                return null;
            }

            return [
                'id' => $agreement->id,
                'type' => $agreement->type,
                'checkbox_title' => $agreement->checkbox_title,
                'agreed' => (bool) $this->{$config['status']},
            ];
        })->filter()->values();
    }

    // --- Status resolver ---
    public static function resolveDisplayStatus($attendance)
    {
        $status = $attendance->status ?? self::STATUS_INCOMPLETE;

        $conforme = $attendance->latestConforme;
        $hasResponse = $conforme && $conforme->response == 1;
        $isAwaitingResponse = $conforme && $conforme->response == 0;

        if ($status == self::STATUS_PENDING_CONFORME_GENERATION &&
            ($attendance->conforme_review ?? 0) == 1
        ) {
            if ($hasResponse) {
                if ($attendance->is_rtb_generated) {
                    return self::LABEL_GENERATED_RTB; 
                }
                return self::LABEL_READY_FOR_RTB;
            }

            if ($isAwaitingResponse || !$conforme) {
                return self::LABEL_AWAITING_CONFORME;
            }
        }

        switch ($status) {
            case self::STATUS_INCOMPLETE:
                return self::LABEL_INCOMPLETE;

            case self::STATUS_PENDING_CONFORME_GENERATION:
                return self::LABEL_PENDING_CONFORME_GENERATION;

            case self::STATUS_PENDING:
                return self::LABEL_PENDING;

            case self::STATUS_REVIEWED:
                return self::LABEL_REVIEWED;

            case self::STATUS_ONHOLD:
                return self::LABEL_ONHOLD;

            case self::STATUS_DENIED:
                return self::LABEL_DENIED;

            default:
                return 'Unknown';
        }
    }

public static function resolvePaymentLabel($attendance)
{
    $status = $attendance->payment_status ?? self::PAYMENT_UNPAID;

    switch ($status) {
        case self::PAYMENT_PAID:
            return self::LABEL_PAYMENT_PAID;

        case self::PAYMENT_PENDING:
            return self::LABEL_PAYMENT_PENDING;

        default:
            return self::LABEL_PAYMENT_UNPAID;
    }
}
    public static function resolveSOALabel($attendance)
    {
        return ($attendance->is_soa_generated ?? false)
            ? self::LABEL_SOA_GENERATED
            : self::LABEL_SOA_NOT_GENERATED;
    }


    public static function getLatestConforme($attendance)
{
    return Conforme::where('ff_code', $attendance->user_id)
        ->where('fair_code', $attendance->fair_code)
        ->latest('created_at')
        ->first();
}
    
    public function event()
{
    return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
}

public function exhibitor()
{
    return $this->belongsTo(Exhibitor::class, 'user_id', 'uid');
}



public static function dashboardSummary(): array
{
    $event = Event::latest('created_at')->first();

    /*
    |--------------------------------------------------------------------------
    | Default Summary
    |--------------------------------------------------------------------------
    */

    $summary = [
        'fair_code' => null,

        'total_registered' => 0,

        // Registration
        'approved' => 0,
        'incomplete' => 0,
        'pending' => 0,
        'reviewed' => 0,
        'onhold' => 0,
        'denied' => 0,

        // Conforme / RTB
        'pending_conforme_generation' => 0,
        'awaiting_conforme_response' => 0,
        'for_rtb' => 0,
        'generated_rtb' => 0,

        // SOA
        'soa_not_generated' => 0,
        'soa_generated' => 0,

        // Payment
        'unpaid' => 0,
        'payment_pending' => 0,
        'paid' => 0,
    ];

    /*
    |--------------------------------------------------------------------------
    | No Active Event
    |--------------------------------------------------------------------------
    */

    if (!$event) {
        return $summary;
    }

    /*
    |--------------------------------------------------------------------------
    | Get Supplier / Exhibitor Attendances
    |--------------------------------------------------------------------------
    */

    $attendances = self::query()
        ->where('fair_code', $event->fair_code)
        ->get();

    $summary['fair_code'] = $event->fair_code;
    $summary['total_registered'] = $attendances->count();

    /*
    |--------------------------------------------------------------------------
    | Process Each Supplier / Exhibitor
    |--------------------------------------------------------------------------
    */

    foreach ($attendances as $attendance) {

        /*
        |--------------------------------------------------------------------------
        | Get Latest Conforme
        |--------------------------------------------------------------------------
        |
        | Match using:
        |   conforme_response.ff_code = exhibitor_attendance.user_id
        |   conforme_response.fair_code = exhibitor_attendance.fair_code
        |
        */

        $latestConforme = Conforme::query()
            ->where('ff_code', $attendance->user_id)
            ->where('fair_code', $attendance->fair_code)
            ->latest('created_at')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Attach Latest Conforme
        |--------------------------------------------------------------------------
        |
        | resolveDisplayStatus() expects:
        |
        | $attendance->latestConforme
        |
        */

        $attendance->setRelation(
            'latestConforme',
            $latestConforme
        );

        /*
        |--------------------------------------------------------------------------
        | Registration / Conforme / RTB
        |--------------------------------------------------------------------------
        */

        $displayStatus = self::resolveDisplayStatus($attendance);

        switch ($displayStatus) {

            case self::LABEL_INCOMPLETE:

                $summary['incomplete']++;

                break;

            case self::LABEL_PENDING_CONFORME_GENERATION:

                $summary['pending_conforme_generation']++;

                break;

            case self::LABEL_AWAITING_CONFORME:

                $summary['awaiting_conforme_response']++;

                break;

            case self::LABEL_READY_FOR_RTB:

                $summary['for_rtb']++;

                break;

            case self::LABEL_GENERATED_RTB:

                $summary['generated_rtb']++;

                break;

            case self::LABEL_PENDING:

                $summary['pending']++;

                break;

            case self::LABEL_REVIEWED:

                $summary['reviewed']++;

                break;

            case self::LABEL_ONHOLD:

                $summary['onhold']++;

                break;

            case self::LABEL_DENIED:

                $summary['denied']++;

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Approved
        |--------------------------------------------------------------------------
        |
        | Approved means:
        |
        | attendance.status = 1
        | AND conforme_review = 1
        | AND latest conforme exists
        | AND latest conforme.response = 1
        |
        | is_rtb_generated does NOT matter.
        |
        */

        if (
            (int) $attendance->status === self::STATUS_PENDING_CONFORME_GENERATION &&
            (int) ($attendance->conforme_review ?? 0) === 1 &&
            $latestConforme &&
            (int) $latestConforme->response === 1
        ) {
            $summary['approved']++;
        }

        /*
        |--------------------------------------------------------------------------
        | SOA
        |--------------------------------------------------------------------------
        */

$isApprovedAndRtbGenerated =
    (int) $attendance->status === self::STATUS_PENDING_CONFORME_GENERATION &&
    (int) ($attendance->conforme_review ?? 0) === 1 &&
    $latestConforme &&
    (int) $latestConforme->response === 1 &&
    (bool) $attendance->is_rtb_generated;

if ($isApprovedAndRtbGenerated) {

    if ((bool) $attendance->is_soa_generated) {
        $summary['soa_generated']++;
    } else {
        $summary['soa_not_generated']++;
    }
}
        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

switch ((int) $attendance->payment_status) {

    case self::PAYMENT_PAID:

        $summary['paid']++;

        break;

    case self::PAYMENT_PENDING:

        $summary['payment_pending']++;

        break;

    default:

        if ((bool) $attendance->is_soa_generated) {
            $summary['unpaid']++;
        }

        break;
}
    }

    return $summary;
}

}
