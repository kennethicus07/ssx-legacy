<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRole extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'company_role_purchasing_activities';

    protected $fillable = [
        'name'
    ];
}
