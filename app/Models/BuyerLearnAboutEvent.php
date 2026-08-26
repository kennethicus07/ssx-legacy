<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerLearnAboutEvent extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'buyers_learn_about_event';

    protected $fillable = [
        'learn_about_event_id',
        'fair_code',
        'remarks'
    ];

    public function show_reason()
    {
        return $this->belongsTo(AboutEvent::class, 'learn_about_event_id', 'id');
    }
}
