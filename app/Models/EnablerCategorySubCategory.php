<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnablerCategorySubCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'enablers_categories_subcategories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabler_id', 'category_id', 'category_remarks', 'sub_category_id', 'sub_category_remarks'
    ];

    public function category()
    {
        return $this->belongsTo(EnablerCategories::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(EnablerSubCategories::class, 'sub_category_id', 'id');
    }
}
