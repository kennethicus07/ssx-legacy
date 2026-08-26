<?php

namespace App\Models\InternalEvent;

use App\Models\BaseModel;
use App\Models\Supplier\Event;
use App\Models\InternalEvent\InternelPromoAllowedCurrency;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalEventPromo extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'internal_event_promos';


    public const TYPE_FREE = 1;
    public const TYPE_DISCOUNTED = 2;
    public const DISCOUNT_PERCENT = 1;
    public const DISCOUNT_FIXED   = 2;

    protected $fillable = [
        'fair_code',
        'promo_code',
        'system_code',
        'promo_type',
        'discount_type',
        'discount_value',
        'max_per_use',
        'usage_limit',
        'access_type',
        'starts_at',
        'expires_at',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /*
    promo_type
    1 = Complimentary, 2 = Discounted
    */

    /*
    discount_type
    nullable = free, 1 = Percent, 2 = Fixed
    */

    /*
    discount_value
    Discount amount (nullable for free)
    */

    /*
    max_per_use
    Max people per single registration (any attendee type)
    */

    /*
    usage_limit
    Max total redemptions across all users (nullable for unlimited)
     */

    /*
    access_type
    1 = Public (anyone can use), 2 = Email-tied (personalized)
    */
    
    /*
    promo_trigger_type	
    tinyint	1	Manual vs Automatic
     */

    /*
    min_attendees	
    integer	6	Needed for 5+1
    */

    /*
    auto_apply	
    tinyint	1	System applies automatically
    */

    /*
    requires_code	
    tinyint	0	User must type code?
    */

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status'     => 'boolean',
        'promo_trigger_type' => 'integer',
        'min_attendees' => 'integer',
        'auto_apply' => 'integer',
        'requires_code' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


 
    public function allowedTypes()
    {
        return $this->hasMany(InternalEventPromoAllowedType::class, 'promo_id');
    }

    public function allowedCurrency(){
        return $this->hasMany(InternelPromoAllowedCurrency::class,'currency_id');
    }

    public function users()
    {
        return $this->hasMany(InternalEventPromoUser::class, 'promo_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }

public function getPromoTypeLabelAttribute(): string
{
    switch ($this->promo_type) {
        case self::TYPE_FREE:
            return 'Free';
        case self::TYPE_DISCOUNTED:
            return 'Discounted';
        default:
            return '';
    }
}

public function getDiscountTypeLabelAttribute(): string
{
    if ($this->promo_type === self::TYPE_FREE || empty($this->discount_type)) {
        return 'Free';
    }

    switch ($this->discount_type) {
        case self::DISCOUNT_PERCENT:
            return 'Percent';
        case self::DISCOUNT_FIXED:
            return 'Fixed';
        default:
            return 'Free';
    }
}

    public function getCreatedByNameAttribute()
    {
        return optional(User::find($this->created_by))->name;
    }

    public function getUpdatedByNameAttribute()
    {
        return optional(User::find($this->updated_by))->name;
    }
}