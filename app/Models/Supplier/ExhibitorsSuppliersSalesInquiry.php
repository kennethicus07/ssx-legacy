<?php

namespace App\Models\Supplier;

use App\Models\Supplier\Event;
use App\Models\User;
use App\Traits\TracksUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitorsSuppliersSalesInquiry extends Model
{
    use HasFactory, TracksUser;

    protected $table = 'exhibitors_suppliers_sales_inquiries';

    protected $fillable = [
        'ff_code',
        'fair_code',
        'date_of_sale',
        'no_of_inquiries',
        'no_of_buyers_met',
    ];

    protected $casts = [
        'date_of_sale' => 'date',
        'no_of_inquiries' => 'integer',
        'no_of_buyers_met' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'ff_code',
            'id'
        );
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    

}