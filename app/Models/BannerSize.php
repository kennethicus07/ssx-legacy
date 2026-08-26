<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class BannerSize extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'banner_sizes';

    protected $fillable = [
        'item_code', 'name', 'description'
    ];

    protected static function booted()
    {
        static::addGlobalScope('banner_active', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }
}
