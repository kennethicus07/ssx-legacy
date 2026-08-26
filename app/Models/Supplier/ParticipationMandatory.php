<?php

namespace App\Models\Supplier;

use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipationMandatory extends Model
{
    use HasFactory;

    protected $table = 'participation_mandatory';
    protected $fillable = [
        'business_type_id',
        'is_required',
        'details',
        'price',
        'currency',
        'status',
        'created_at',
        'updated_at',
    ];

    public function business_type(){
        return $this->belongsTo(BusinessType::class, 'business_type_id', 'id');
    }
}
