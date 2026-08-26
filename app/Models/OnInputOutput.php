<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnInputOutput extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'on_input_output';

    protected $fillable = [
        'name', 'item_code'
    ];
}
