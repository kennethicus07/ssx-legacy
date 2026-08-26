<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorBuyerCategorySubCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_buyers_categories_subcategories';

    protected $fillable = [
        'uid',
        'category_id',
        'fair_code',
        'category_remarks',
        'sub_category_id',
        'sub_category_remarks'
    ];
}
