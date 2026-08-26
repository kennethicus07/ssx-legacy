<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnablerSubCategories extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'enablers_subcategories';

    protected $fillable = [
        'category_id', 'name'
    ];

    public function category()
    {
        return $this->belongsTo(EnablerCategories::class, 'category_id', 'id');
    }
}
