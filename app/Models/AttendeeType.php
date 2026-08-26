<?php

namespace App\Models;

use App\Models\InternalEvent\InternalEventPromoAllowedType;
use App\Models\InternalEvent\InternalEventPromoUser;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendeeType extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'attendee_types';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status'     => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //! Attendee Type Constants
    const SUPPLIER_EXHIBITOR = 1;
    const PURCHASER_BUYER   = 2;
    const DELEGATE          = 3;

    //! Relationships
    public function promoAllowedTypes()
    {
        return $this->hasMany(InternalEventPromoAllowedType::class, 'attendee_type_id');
    }

    public function promoUsers()
    {
        return $this->hasMany(InternalEventPromoUser::class, 'attendee_type_id');
    }
}