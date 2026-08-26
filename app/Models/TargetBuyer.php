<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetBuyer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'target_buyers';

    protected $fillable = [
        'name',
        'status'
    ];
}
