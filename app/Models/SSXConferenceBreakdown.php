<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSXConferenceBreakdown extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'ssx_conference_breakdown';

    public const TYPE_BASE = 'base'; 
    public const TYPE_DISCOUNT = 'discount'; 
    public const TYPE_ADD_FEE = 'add_fee'; 
    public const TYPE_ADD_DISCOUNT = 'add_discount';

    protected $fillable = [
        'ssx_conference_id',
        'code',
        'system_code',
        'type',
        'count',
        'value',
        'description'
    ];

    public function conference() {
        return $this->belongsTo(SSXConference::class, 'ssx_conference_id');
    }
}
