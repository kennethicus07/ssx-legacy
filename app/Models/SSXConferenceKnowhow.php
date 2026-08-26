<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSXConferenceKnowhow extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'ssx_conference_knowhow';

    protected $fillable = [
        'ssx_conference_id',
        'value',
        'know_how_other',
    ];

    public function conference() {
        return $this->belongsTo(SSXConference::class, 'ssx_conference_id');
    }
}
