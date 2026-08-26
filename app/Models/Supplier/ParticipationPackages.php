<?php

namespace App\Models\Supplier;

use App\Scopes\AdminOnlyScope;
use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationPackages extends Model
{
    use HasFactory;

    protected $table = 'participation_packages';
    protected $fillable = [
        'title',
        'sub_title',
        'min_booth_size',
        'max_booth_size',
        'booth_details',
        'images',
        'status',
        'admin_only',
        'created_at',
        'updated_at',
    ];

     protected static function booted()
    {
        static::addGlobalScope(new StatusScope());
        static::addGlobalScope(new AdminOnlyScope());
    }
      public function participation_booth_sizes()
    {
        return $this->hasMany(ParticipationBoothSizes::class, 'package_id', 'id');
    }
      public function participation_booth_spaces()
    {
        return $this->hasMany(ParticipationSpaces::class, 'package_id', 'id');
    }

}
