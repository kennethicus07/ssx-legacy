<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sdg;
use App\Models\User;
use App\Models\Supplier\Event;

class ExhibitorSdg extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'exhibitors_sdgs';

    protected $fillable = [
        'uid',
        'fair_code',
        'sdg_id',
    ];

    public function product_char_sdg()
    {
        return $this->belongsTo(Sdg::class, 'sdg_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }

  

}
