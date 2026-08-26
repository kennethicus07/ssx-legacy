<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationAddOn extends Model
{
    use HasFactory;

       protected $table = 'participation_add_on';
    protected $fillable = [
        'name',
        'unit',
        'notes',
        'qty_type',
        'order',
        'group',
        'fair_code',
        'status',
        'limit_per_exhibitor',
        'limit_overall',        
        'created_at',
        'updated_at',
    ];

public function rates() {
    return $this->hasMany(ParticipationAddOnRates::class, 'participation_addon_id', 'id');
}
}
