<?php

namespace App\Models\InternalEvent;

use App\Models\Currency;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalEventPromoAllowedDelegateType extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'internal_event_promo_allowed_delegate_types';

    protected $fillable = [
        'promo_id',
        'name',
    ];


    //! Relationships
    public function promo()
    {
        return $this->belongsTo(InternalEventPromo::class, 'promo_id');
    }

}