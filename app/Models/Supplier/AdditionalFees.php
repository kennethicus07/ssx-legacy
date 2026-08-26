<?php

namespace App\Models\Supplier;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFees extends Model
{
    use HasFactory;

        public $timestamps = true;

        protected $table = 'additional_fees';

        protected $fillable = [
            'ff_code',
            'fair_code',
            'remarks',
            'amount',
            'currency',
            'type',
            'added_by',
            'updated_by'
        ];


            public function user()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

}
