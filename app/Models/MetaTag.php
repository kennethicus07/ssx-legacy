<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaTag extends Model
{
    use HasFactory;

    protected $table = 'seo_meta_tags_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'page', 'meta_title', 'meta_keywords', 'meta_robots', 'meta_author', 'meta_image', 'added_by', 'edited_by'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
