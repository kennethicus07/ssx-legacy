<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothKioskSpaces extends Model
{
    use HasFactory;

     protected $table = 'booth_kiosk_spaces';
    protected $fillable = [
        'name',
        'description',
        'fair_code',
        'status',
        'display_in_kiosk',
        'x',
        'y',
        'cols',
        'rows',
        'width',
        'height',
        'start_x',
        'start_y',
        'color_inHex',
        'created_at',
        'updated_at',
    ];
}
