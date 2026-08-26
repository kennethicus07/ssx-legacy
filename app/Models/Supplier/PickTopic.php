<?php

namespace App\Models\Supplier;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickTopic extends Model
{
    use HasFactory;


      public $timestamps = false;
    protected $table = 'exhibitors_topic_picks';

    protected $fillable = [
        'uid',
        'topic_id',
        'fair_code',
    ];
    public function focus_topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }
     public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
    
}
