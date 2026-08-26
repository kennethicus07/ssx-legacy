<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothSystemAssignment extends Model
{
    use HasFactory;

    protected $table = 'booth_system_assignments';

    protected $fillable = [
        'fair_code',
        'name',
        'created_by',
        'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function groups()
    {
        return $this->hasMany(
            BoothSystemAssigmnetGroup::class,
            'booth_system_assignment_id',
            'id'
        );
    }
}