<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorOnInputOutput extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_on_input_output';

    protected $fillable = [
        'uid',
        'fair_code',
        'input_output_id',
    ];

    public function product_char_inputoutput()
    {
        return $this->belongsTo(OnInputOutput::class, 'input_output_id', 'id');
    }
}
