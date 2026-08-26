<?php

namespace App\Models\Buyer;

use App\Models\User;
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
    return $this->hasMany(BuyerAttendance::class, 'fair_code', 'fair_code');
}
}
