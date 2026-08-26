<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\Event;

class SSXConference extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'ssx_conference';

    /*
    |--------------------------------------------------------------------------
    | Workflow Constants
    |--------------------------------------------------------------------------
    */

    public const WORKFLOW_FOR_REVIEW = 'FOR REVIEW';
    public const WORKFLOW_FOR_ACCOUNTING_REVIEW = 'FOR ACCOUNTING REVIEW';
    public const WORKFLOW_FOR_CASHIER = 'FOR CASHIER';

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT = 0;
    public const STATUS_INCOMPLETE = 1;
    public const STATUS_REGISTERED = 2;

    /*
    |--------------------------------------------------------------------------
    | Billing Status Constants
    |--------------------------------------------------------------------------
    |
    | 0 = Not Generated
    | 1 = Approved
    | 2 = For Approval
    | 3 = Generated
    |
    */

    public const BILLING_NOT_GENERATED = 0;
    public const BILLING_APPROVED = 1;
    public const BILLING_FOR_APPROVAL = 2;
    public const BILLING_GENERATED = 3;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'registration_number',
        'fair_code',
        'business_type',
        'participant_count',
        'currency',
        'base_rate',
        'amount',
        'discount',
        'final_amount',
        'company_name',
        'company_address',
        'tin',
        'contact_person',
        'contact_person_salutation',
        'company_email',
        'contact_number',
        'dietary',
        'dietary_details',
        'certificate',
        'promotional_email',
        'billing_file',
        'review_by',
        'is_review',
        'review_at',
        'billing_by',
        'billing_status',
        'billing_at',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

protected $casts = [
    'participant_count' => 'integer',
    'base_rate' => 'decimal:2',
    'amount' => 'decimal:2',
    'discount' => 'decimal:2',
    'final_amount' => 'decimal:2',
    'billing_status' => 'integer',
];

    /*
    |--------------------------------------------------------------------------
    | Workflow Status
    |--------------------------------------------------------------------------
    */

public function getWorkflowStatusAttribute(): ?string
{
    if ((int) $this->status !== self::STATUS_REGISTERED) {
        return null;
    }

    $isReview = (int) ($this->is_review ?? 0);
    $billingStatus = (int) ($this->billing_status ?? self::BILLING_NOT_GENERATED);

    // Registered + Not Reviewed + Billing Not Generated
    if (
        $isReview === 0 &&
        $billingStatus === self::BILLING_NOT_GENERATED
    ) {
        return self::WORKFLOW_FOR_REVIEW;
    }

    // Registered + Reviewed + Billing Not Generated
    if (
        $isReview === 1 &&
        $billingStatus === self::BILLING_NOT_GENERATED
    ) {
        return self::WORKFLOW_FOR_ACCOUNTING_REVIEW;
    }

    // Registered + Reviewed + Billing Generated
    if (
        $isReview === 1 &&
        $billingStatus === self::BILLING_GENERATED
    ) {
        return self::WORKFLOW_FOR_CASHIER;
    }

    return null;
}

    /*
    |--------------------------------------------------------------------------
    | Review Status
    |--------------------------------------------------------------------------
    */

    public function getReviewStatusAttribute(): string
    {
        return (int) $this->is_review === 1
            ? 'Yes'
            : 'No';
    }

    /*
    |--------------------------------------------------------------------------
    | Billing Status
    |--------------------------------------------------------------------------
    */

    public function getSoaBillingStatusAttribute(): string
    {
        switch ((int) $this->billing_status) {

            case self::BILLING_APPROVED:
                return 'Approved';

            case self::BILLING_FOR_APPROVAL:
                return 'For Approval';

            case self::BILLING_GENERATED:
                return 'Generated';

            default:
                return 'Not Generated';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User Relationships
    |--------------------------------------------------------------------------
    */

    public function reviewBy()
    {
        return $this->belongsTo(
            User::class,
            'review_by',
            'id'
        );
    }

    public function billingBy()
    {
        return $this->belongsTo(
            User::class,
            'billing_by',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Conference Relationships
    |--------------------------------------------------------------------------
    */

    public function conferenceDelegates()
    {
        return $this->hasMany(
            SSXConferenceDelegate::class,
            'ssx_conference_id'
        );
    }

    public function conferenceSoa()
    {
        return $this->hasMany(
            SSXConferenceSoa::class,
            'ssx_conference_id'
        );
    }

    public function conferenceBreakdown()
    {
        return $this->hasMany(
            SSXConferenceBreakdown::class,
            'ssx_conference_id'
        );
    }

    public function conferenceKnowhow()
    {
        return $this->hasMany(
            SSXConferenceKnowhow::class,
            'ssx_conference_id'
        );
    }

    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'fair_code',
            'fair_code'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePerFair($query, $fairCode)
    {
        return $query->where('fair_code', $fairCode);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '>', 0);
    }
}