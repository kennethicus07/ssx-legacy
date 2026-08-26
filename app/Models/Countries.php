<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'continent',
        'code',
        'iso3',
        'number',
        'dial'
    ];
}
