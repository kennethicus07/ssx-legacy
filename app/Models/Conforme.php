<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conforme extends Model
{
     use HasFactory;

    public $timestamps = true;
    protected $table = 'conforme_response';

    protected $fillable = [
        'ff_code',
        'fair_code',
        'email_token',
        'recipient_email',
        'noa_file',
        'date_sent',
        'response',
        'date_responded',
        'created_at',
        'updated_at'
    ];

        protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'response' => 'integer',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

    

}


