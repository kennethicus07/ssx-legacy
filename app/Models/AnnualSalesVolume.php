<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualSalesVolume extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'annual_sales_volumes';

    protected $fillable = [
        'name'
    ];
}
