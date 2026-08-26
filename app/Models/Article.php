<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'sub_title',
        'author',
        'content',
        'image_thumb',
        'image_banner',
        'status',
        'is_carousel',
        'is_featured',
        'type_id',
        'enabler_id',
        'article_type',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'added_by',
        'edited_by'
    ];

    public function category_tag()
    {
        return $this->hasMany(ArticleCategorySubCategory::class, 'article_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }

    public function enabler()
    {
        return $this->belongsTo(Enabler::class, 'enabler_id', 'id');
    }
}
