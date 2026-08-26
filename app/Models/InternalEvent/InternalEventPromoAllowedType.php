<?php

namespace App\Models\InternalEvent;

use App\Models\AttendeeType;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalEventPromoAllowedType extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'internal_event_promo_allowed_types';

    protected $fillable = [
        'promo_id',
        'attendee_type_id',
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

    //! Relationships
    public function promo()
    {
        return $this->belongsTo(InternalEventPromo::class, 'promo_id');
    }

    public function attendeeType()
    {
        return $this->belongsTo(AttendeeType::class, 'attendee_type_id');
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