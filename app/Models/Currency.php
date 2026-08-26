<?php

namespace App\Models;

use App\Models\InternalEvent\InternelPromoAllowedCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'symbol',
        'name',
        'status'
    ];

    protected $cast = [
        'status' => 'boolean',
    ];


public function promoAllowedCurrencies(){
    return $this->hasMany(InternelPromoAllowedCurrency::class,'currency_id');
}
}

