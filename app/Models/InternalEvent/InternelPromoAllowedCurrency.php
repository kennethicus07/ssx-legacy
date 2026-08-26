<?php

namespace App\Models\InternalEvent;

use App\Models\Currency;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternelPromoAllowedCurrency extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'internal_event_promo_allowed_currencies';


    protected $fillable = [
        'promo_id',
        'currency_id',
        'value',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //! Relationships
    public function promo()
    {
        return $this->belongsTo(InternalEventPromo::class, 'promo_id');
    }

    public function currencyType()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    //! Accessors
    public function getCreatedByNameAttribute()
    {
        return optional(User::find($this->created_by))->name;
    }

    public function getUpdatedByNameAttribute()
    {
        return optional(User::find($this->updated_by))->name;
    }
}