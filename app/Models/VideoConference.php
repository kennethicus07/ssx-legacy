<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConference extends Model
{
    use HasFactory;

    protected $table = 'conferences_videos';

    protected $fillable = [
        'conference_id', 'video_link', 'video_id', 'details', 'status', 'added_by', 'edited_by'
    ];

    public function createdby()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modifiedby()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_id', 'id');
    }
}
