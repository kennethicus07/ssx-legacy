<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricalLog extends Model
{
    use HasFactory;

          protected $table = 'historical_logs';
    protected $fillable = [
        'causer_ff_code',
        'fair_code',
        'target_ff_code',
        'process',
        'description',
    ];    
    
    public function causerFfCode()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

    
    public function targetFfCode()
    {
        return $this->belongsTo(User::class,  'target_ff_code', 'id');
    }
}







