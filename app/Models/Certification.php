<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Certification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'certifications';

    protected $fillable = [
        'name', 'details', 'logo', 'status', 'added_by', 'edited_by'
    ];

    protected static function booted()
    {
        static::addGlobalScope('certifications_active', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    public function createdby()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function modifiedby()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id');
    }
}
