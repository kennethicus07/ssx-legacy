<?php

namespace App\Models\Supplier;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationAddOnSelection extends Model
{
    use HasFactory;
     protected $table = 'participation_add_on_selection';
    protected $fillable = [
        'ff_code',
        'participation_addon_id',
        'fair_code',
        'qty',
        'total_amount_due',
        'status',
        'added_by',
        'created_at',
        'updated_at',
    ];
public function user() {
    return $this->belongsTo(User::class, 'ff_code', 'id');
}

public function addOn()
{

    return $this->belongsTo(ParticipationAddOn::class, 'participation_addon_id', 'id');
}

public function addOnRates()
{
    return $this->hasMany(
        ParticipationAddOnRates::class,
        'participation_addon_id',
        'participation_addon_id'
    );
}

public function addedBy() {
    return $this->belongsTo(User::class, 'added_by', 'id');
}


}
