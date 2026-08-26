<?php

namespace App\Models\Supplier;

use App\Models\Exhibitor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationBoothSelection extends Model
{
    use HasFactory;

     protected $table = 'participation_booth_selection';

     protected $fillable = [
        'ff_code',
        'package_id',
        'fair_code', 
        'space_id',
        'invoice_id',
        'booth_size_code',
        'booth_size_name',
        'booth_amount',
        'booth_package',
        'booth_qty',
        'booth_package_remarks',
        'total_participation',
        'total_amount_due',
        'currency',
        'sub_total',
        'added_by',
        'status',
        'discount',
        'discount_remarks',
        'created_at',
        'updated_at',
    ];


public function package()
{
    return $this->belongsTo(ParticipationPackages::class, 'package_id', 'id')
        ->select(['id', 'title', 'sub_title']); 
}

public function space()
{
    return $this->belongsTo(ParticipationSpaces::class, 'space_id', 'id')
        ->select(['id', 'name']); 
}


     public function size()
    {
        return $this->belongsTo(ParticipationBoothSizes::class, 'booth_size_code', 'id'); 
      
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }
    
     public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
    
    
   
}
