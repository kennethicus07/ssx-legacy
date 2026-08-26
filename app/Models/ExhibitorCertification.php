<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorCertification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_certifications';

    protected $fillable = [
        'uid',
        'fair_code',
        'certification_id',
        'remarks'
    ];

    public function food_cert()
    {
        return $this->belongsTo(Certification::class, 'certification_id', 'id');
    }
}
