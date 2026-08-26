<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureBusiness extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'nature_businesses';

    protected $fillable = [
        'name'
        
    ];
}
