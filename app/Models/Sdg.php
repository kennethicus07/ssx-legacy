<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdg extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'sdgs';

    protected $fillable = [
        'name', 'item_code'
    ];
}
