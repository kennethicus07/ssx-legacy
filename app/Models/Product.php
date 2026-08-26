<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'products';

    protected $fillable = [
        'uid','fair_code', 'name', 'slug', 'description', 'store_url', 'status', 'created_at', 'updated_at'
    ];

    public function product_images()
    {
        return $this->hasMany(ProductPhoto::class, 'product_id', 'id');
    }

    public function product_image()
    {
        return $this->hasMany(ProductPhoto::class, 'product_id', 'id')->limit(1);
    }

    public function product_profiles()
    {
        return $this->hasMany(ProductProfile::class, 'product_id', 'id');
    }

    public function product_certifications()
    {
        return $this->hasMany(ProductCertification::class, 'product_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
}
