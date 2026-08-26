<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';
    protected $dates = ['event_date_1','event_date_2'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'event_happening',
        'event_type',
        'event_date_1',
        'event_date_2',
        'content',
        'organizer',
        'platform',
        'location',
        'event_link',
        'description',
        'organizer_logo',
        'event_banner',
        'status',
        'is_educate',
        'is_aboutus',
        'is_featured',
        'meta_title',
        'meta_description',
        'added_by',
        'edited_by'
    ];

    public function category_tag()
    {
        return $this->hasMany(EventCategorySubCategory::class, 'event_id', 'id');
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
