<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAnnualSales extends Model
{
    use HasFactory;

   protected $table = 'company_annual_sales';

   protected $fillable = [
     'name'
    ];
}
