<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorTargetBuyer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_target_buyers';

    protected $fillable = [
        'uid',
        'fair_code',
        'target_buyer_id',
        'remarks'
    ];

      public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
    
public function natureBusiness()
    {
        return $this->belongsTo(TargetBuyer::class, 'target_buyer_id', 'id');
    }

    public function targetBuyer()
    {
        return $this->belongsTo(TargetBuyer::class, 'target_buyer_id', 'id');
    }
}
