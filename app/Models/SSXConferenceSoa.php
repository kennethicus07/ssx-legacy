<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSXConferenceSoa extends Model
{
    use HasFactory;

    protected $table = 'ssx_conference_soas';

    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    |
    | 0 = Rejected
    | 1 = Approved
    |
    */

    public const STATUS_REJECTED = 0;
    public const STATUS_APPROVED = 1;

    protected $fillable = [
        'ssx_conference_id',
        'fair_code',
        'soa_file',
        'date_issued',
        'date_due',
        'vat_rate',
        'vat_exempted',
        'vat_zero_exempted',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_due' => 'date',
        'status' => 'integer',
        'vat_rate' => 'decimal:2',
        'vat_exempted' => 'boolean',
        'vat_zero_exempted' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function conference()
    {
        return $this->belongsTo(
            SSXConference::class,
            'ssx_conference_id'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function updatedBy()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isApproved(): bool
    {
        return (int) $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return (int) $this->status === self::STATUS_REJECTED;
    }
}