<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorDocument extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_documents';

    protected $fillable = [
        'uid', 'fair_code', 'dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate', 'institutional_catalog','business_certification', 'food_or_environmental_certification'    
    ];
}

