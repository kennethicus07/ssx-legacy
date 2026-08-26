<?php

namespace App\Models\Supplier;

use App\Models\BusinessType;
use App\Scopes\AdminOnlyScope;
use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationSpaces extends Model
{
    use HasFactory;
 protected $table = 'participation_spaces';
 
    protected $fillable = [
        'package_id',
        'business_type_id',
        'type',
        'currency',
        'cost_per_sqm',
        'booth_min_size',
        'booth_max_size',
        'booth_size_unit',
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

       public function package()
    {
        return $this->belongsTo(ParticipationPackages::class, 'package_id', 'id');
    }
    
    public function foreign_local(){
        return $this->belongsTo(BusinessType::class,'business_type_id','id');
    }

       public function participation_booth_sizes()
    {
        return $this->hasMany(ParticipationBoothSelection::class, 'package_id', 'id');
    }
}
