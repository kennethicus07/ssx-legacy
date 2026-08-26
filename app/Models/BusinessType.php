<?php

namespace App\Models;

use App\Models\Supplier\ParticipationMandatory;
use App\Models\Supplier\ParticipationSpaces;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'business_types';

    protected $fillable = [
        'name'
    ];

     public function participation_mandatory(){
        return $this->hasOne(ParticipationMandatory::class, 'business_type_id', 'id');
    }

    public function participation_spaces(){
        return $this->hasMany(ParticipationSpaces::class,'business_type_id','id');
    }
}
