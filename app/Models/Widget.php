<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Widget extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'widgets';

    protected $fillable = [
        'title', 'details', 'status', 'added_by', 'edited_by'
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
