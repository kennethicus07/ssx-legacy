<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnablerCategories extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'enablers_categories';

    protected $fillable = [
        'name'
    ];

    public function enabler_sub_categories()
    {
        return $this->hasMany(EnablerSubCategories::class, 'category_id', 'id');
    }
}
