<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationGoal extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'participation_goals';

    protected $fillable = [
        'name', 
        'item_code', 
        'status'
    ];
}
