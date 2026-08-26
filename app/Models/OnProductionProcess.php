<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnProductionProcess extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'on_production_process';

    protected $fillable = [
        'name', 'item_code'
    ];
}
