<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorBuyerNatureBusiness extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_buyers_nature_businesses';

    protected $fillable = [
        'uid',
         'fair_code',
        'nature_business_id',
        'remarks'
    ];

  public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
    
public function natureBusiness()
    {
        return $this->belongsTo(NatureBusiness::class, 'nature_business_id', 'id');
    }
}
