<?php

namespace App\Models\Supplier;

use App\Models\BaseModel;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorPayment extends BaseModel
{
    use HasFactory, TracksUser;

    protected $table = 'exhibitor_payments';

    protected $fillable = [
        'ff_code',
        'fair_code',
        'payment_file',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
    ];


    /**
     * The user who uploaded the payment proof
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }



    /**
     * Link to the exhibitor attendance
     */
    public function attendance()
    {
        return $this->belongsTo(ExhibitorAttendance::class, 'ff_code', 'user_id')
                    ->whereColumn('fair_code', 'exhibitor_attendance.fair_code');
    }

   public function user()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

    


        public function event()
    {
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }
}