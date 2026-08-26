<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothKioskAssignment extends Model
{
    use HasFactory;
         protected $table = 'booth_kiosk_assignments';
    protected $fillable = [
        'remarks',
        'ff_Code',
        'contactProfile_id',
        'contactProfile_type',
        'booth_space_id',
        'fair_code',
        'updated_by',
        'created_at',
        'updated_at',
      
    ];
}
