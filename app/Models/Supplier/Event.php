<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\InternalEvent\InternalEventPromo;
use App\Models\InternalEvent\InternalEventPromoUser;

class Event extends Model
{
    use HasFactory;

    protected $table = 'internal_events';

    protected $fillable = [
        'event_name',
        'location',
        'slug',
        'fair_code',
        'description',
        'event_start',
        'event_end',
        'registration_start',
        'registration_end',
        'status',
        'logo',
        'show_info_link',
        'masthead',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'event_start' => 'datetime',
        'event_end' => 'datetime',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Relations
    public function exhibitorAttendances()
    {
        return $this->hasMany(ExhibitorAttendance::class, 'fair_code', 'fair_code');
    }

    public function promos()
    {
        return $this->hasMany(InternalEventPromo::class, 'fair_code', 'fair_code');
    }

    public function activePromos()
    {
        return $this->promos()->active();
    }

    public function promoUsers()
    {
        return $this->hasMany(InternalEventPromoUser::class, 'fair_code', 'fair_code');
    }

    // Helper
    public function getFormattedDateRangeAttribute()
    {
        $start = Carbon::parse($this->event_start);
        $end   = Carbon::parse($this->event_end);

        if ($start->format('F') === $end->format('F')) {
            return $start->format('F j') . '–' . $end->format('j, Y');
        }

        return $start->format('F j') . ' – ' . $end->format('F j, Y');
    }
}