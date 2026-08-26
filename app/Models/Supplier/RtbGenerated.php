<?php

namespace App\Models\Supplier;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksUser;
use Illuminate\Support\Facades\Auth;

class RtbGenerated extends Model
{
    use HasFactory, TracksUser;

    protected $table = 'rtb_generated';

    const UPDATED_AT = null;
    protected $fillable = [
        'ff_code',
        'fair_code',
        'rtb_file',
        'venue',
        'event_date'
    ];

    protected static function bootTracksUser()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function event(){
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }

    public function exhibitor()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}