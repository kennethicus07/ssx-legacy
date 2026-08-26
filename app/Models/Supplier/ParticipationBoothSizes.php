<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationBoothSizes extends Model
{
    use HasFactory;
    protected $table = 'participation_booth_sizes';
    protected $fillable = [
        'code',
        'name',
        'status',
        'package_id',
        'is_9plus1_promo', 
        'code_promo',
    ];

       public function package()
    {
        return $this->belongsTo(ParticipationPackages::class, 'package_id', 'id');
    }

     public function size()
    {
        return $this->hasMany(ParticipationBoothSelection::class, 'booth_size_code', 'id'); 
      
    }
}
