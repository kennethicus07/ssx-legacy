<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorBusinessOwner extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_business_owner';

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
    ];

}
