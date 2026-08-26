<?php

namespace App\Models\Supplier;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;

    
        public $timestamps = true;

        protected $table = 'discounts';

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

        public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

          public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
