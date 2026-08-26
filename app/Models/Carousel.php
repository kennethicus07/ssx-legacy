<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carousel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'home_carousel';

    protected $fillable = [
        'title', 'details', 'banner', 'url', 'status', 'added_by', 'edited_by'
    ];

    public function createdby()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modifiedby()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
