<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategorySubCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'events_categories_subcategories';

    protected $fillable = [
        'event_id','category_id', 'category_remarks', 'sub_category_id', 'sub_category_remarks'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
