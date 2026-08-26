<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enabler extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'export_enablers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'co_name', 'co_email', 'co_details', 'co_logo', 'thumb_image', 'website', 'facebook', 'instagram', 'twitter', 'wechat',
        'status', 'is_featured', 'added_by', 'edited_by'
    ];

    public function category_tag()
    {
        return $this->hasMany(EnablerCategorySubCategory::class, 'enabler_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modified_by()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
