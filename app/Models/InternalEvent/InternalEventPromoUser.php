<?php

namespace App\Models\InternalEvent;

use App\Models\AttendeeType;
use App\Models\BaseModel;
use App\Models\SSXConference;
use App\Models\Supplier\Event;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalEventPromoUser extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'internal_event_promo_users';

    protected $fillable = [
        'fair_code',
        'promo_id',
        'email',
        'promo_code',
        'attendee_type_id',
        'qty',
        'redeemed',
        'redeemed_at',
        'redeemed_by_email',
        'starts_at',
        'expires_at',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'redeemed'    => 'boolean',
        'redeemed_at' => 'datetime',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status'      => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
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

    public function event()
    {
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function delegate()
    {
        return $this->hasMany(SSXConference::class, 'company_email', 'email');
    }

    //! Accessors
    public function getResolvedEmailAttribute()
    {
        if (in_array($this->attendee_type_id, [
            AttendeeType::SUPPLIER_EXHIBITOR,
            AttendeeType::PURCHASER_BUYER
        ])) {
            return optional($this->user)->email ?? $this->email;
        }

        if ($this->attendee_type_id == AttendeeType::DELEGATE) {
            return optional($this->delegate)->first()->company_email ?? $this->email;
        }

        return $this->email;
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }



    public function scopeSortByAttendeeTypeName($query, $direction = 'asc')
    {
        return $query->join('attendee_types', 'attendee_types.id', '=', 'internal_event_promo_users.attendee_type_id')
                     ->orderBy('attendee_types.name', $direction)
                     ->select('internal_event_promo_users.*');
    }

    //! Created / Updated by accessors
    public function getCreatedByNameAttribute()
    {
        return optional(User::find($this->created_by))->name;
    }

    public function getUpdatedByNameAttribute()
    {
        return optional(User::find($this->updated_by))->name;
    }
}