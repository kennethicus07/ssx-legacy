<?php

namespace App\Models\Supplier;

use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationAddOnRates extends Model
{
    use HasFactory;

     protected $table = 'participation_add_on_rates';
    protected $fillable = [
        'participation_addon_id',
        'business_type_id',
        'currency',
        'cost',
        'status',
        'created_at',
        'updated_at',
    ];

   public function businessType() {
    return $this->belongsTo(BusinessType::class, 'business_type_id', 'id');
}
public function addOn() {
    return $this->belongsTo(ParticipationAddOn::class, 'participation_addon_id', 'id');
}
  
}
