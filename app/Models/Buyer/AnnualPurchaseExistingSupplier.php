<?php

namespace App\Models\Buyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualPurchaseExistingSupplier extends Model
{
    use HasFactory;

    protected $table = 'annual_purchase_existing_supplier';

     protected $fillable = [
        'name'
    ];  
}
