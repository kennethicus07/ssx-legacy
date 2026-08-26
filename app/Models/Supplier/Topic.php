<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    
    public $timestamps = false;
    protected $table = 'topics';

    protected $fillable = [
        'name', 'item_code', 'status'
    ];

     protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('status', 1);
        });
    }
}
