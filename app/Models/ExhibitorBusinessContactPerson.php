<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorBusinessContactPerson extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_business_contact_person';

    protected $fillable = [
        'uid',
        'fair_code',
        'salutation',
        'fname',
        'lname',
        'mi',
        'designation',
        'email',
        'country_code',
        'mobile_no',
        'same_as_bo'
    ];
}
