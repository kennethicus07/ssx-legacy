<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $table = 'conferences';
    protected $dates = ['conference_date'];

    protected $fillable = [
        'title', 'sub_title', 'conference_date', 'status', 'added_by', 'edited_by'
    ];

    public function createdby()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modifiedby()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }

    public function videos()
    {
        return $this->hasMany(VideoConference::class, 'conference_id', 'id');
    }
}
