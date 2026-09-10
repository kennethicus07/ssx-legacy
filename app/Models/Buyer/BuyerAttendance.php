<?php

namespace App\Models\Buyer;

use App\Models\User;
use App\Models\Supplier\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerAttendance extends Model
{
    use HasFactory;

    protected $table = 'buyer_attendance';

    protected $fillable = [
        'fair_code',
        'user_id',
        'qr_token',
        'qr_file',
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
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function buyerAttendances()
    {
        return $this->hasMany(
            BuyerAttendance::class,
            'fair_code',
            'fair_code'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Summary
    |--------------------------------------------------------------------------
    */

    public static function dashboardSummary()
    {
        // Get latest event
        $event = Event::latest('created_at')->first();

        if (! $event) {
            return [
                'approved'         => 0,
                'denied'           => 0,
                'pending'          => 0,
                'reviewed'         => 0,
                'onhold'           => 0,
                'incomplete'       => 0,
                'total_registered' => 0,
            ];
        }

        $fairCode = $event->fair_code;

        $baseQuery = self::where(
            'fair_code',
            $fairCode
        );

        $approved = (clone $baseQuery)
            ->where('status', 1)
            ->count();

        $pending = (clone $baseQuery)
            ->where('status', 2)
            ->count();

        $reviewed = (clone $baseQuery)
            ->where('status', 3)
            ->count();

        $onhold = (clone $baseQuery)
            ->where('status', 4)
            ->count();

        $denied = (clone $baseQuery)
            ->where('status', 5)
            ->count();

        $incomplete = (clone $baseQuery)
            ->where('status', 0)
            ->count();

        $totalRegistered = (clone $baseQuery)->count();

        return [
            'approved'         => number_format($approved),
            'denied'           => number_format($denied),
            'pending'          => number_format($pending),
            'reviewed'         => number_format($reviewed),
            'onhold'           => number_format($onhold),
            'incomplete'       => number_format($incomplete),
            'total_registered' => number_format($totalRegistered),
            'fair_code'        => $fairCode,
        ];
    }
}