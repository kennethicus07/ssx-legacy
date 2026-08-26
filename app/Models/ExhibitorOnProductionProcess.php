<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorOnProductionProcess extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'exhibitors_on_production_process';

    protected $fillable = [
        'uid',
         'fair_code',
        'production_process_id',
        'other_certification',
    ];

    public function product_char_prod_process()
    {
        return $this->belongsTo(OnProductionProcess::class, 'production_process_id', 'id');
    }
}
