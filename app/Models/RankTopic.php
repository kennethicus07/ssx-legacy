<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankTopic extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'rank_topics';

    protected $fillable = [
        'name', 'item_code'
    ];
}
