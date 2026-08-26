<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerParticipatonGoal extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'buyers_participation_goals';

    protected $fillable = [
        'participation_id',
        'fair_code',
        'remarks'
    ];

    public function inform_thru()
    {
        return $this->belongsTo(ParticipationGoal::class, 'participation_id', 'id');
    }
}
