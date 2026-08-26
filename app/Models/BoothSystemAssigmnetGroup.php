<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothSystemAssigmnetGroup extends Model
{
    use HasFactory;

    protected $table = 'booth_system_assignment_groups';

    protected $fillable = [
        'uid',
        'name',
        'booth_system_assignment_id',
        'fair_code',
        'classification',
        'booth_name',
        'booth_name_length',
        'booth_type',
        'hall_name',
        'booth',
        'assigned_by',
    ];

    public function assignment()
    {
        return $this->belongsTo(
            BoothSystemAssignment::class,
            'booth_system_assignment_id',
            'id'
        );
    }

    

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }
}