<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'product_photos';

    protected $fillable = [
        'product_id', 'image', 'img_size', 'img_type', 'img_ext'
    ];
}
