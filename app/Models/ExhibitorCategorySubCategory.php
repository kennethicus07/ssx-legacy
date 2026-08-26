<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorCategorySubCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_categories_subcategories';

    protected $fillable = [
        'uid',
        'category_id',
        'category_remarks',
        'sub_category_id',
        'sub_category_remarks'
    ];
}
