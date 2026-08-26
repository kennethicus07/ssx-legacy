<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorTopicRank extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_topic_ranking';

    protected $fillable = [
        'uid',
        'topic_id',
        'rank'
    ];

    public function focus_ranking()
    {
        return $this->belongsTo(RankTopic::class, 'topic_id', 'id');
    }
}
