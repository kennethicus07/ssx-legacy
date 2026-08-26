<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCertification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'product_certifications';

    protected $fillable = [
        'product_id', 'certification_id', 'remarks'
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class, 'certification_id', 'id');
    }
}
