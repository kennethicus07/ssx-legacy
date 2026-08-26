<?php

namespace App\Models\Supplier;

use App\Enums\SalesTypeStatus;
use App\Models\Countries;
use App\Models\Exhibitor;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\TracksUser;

class ExhibitorsSuppliersSale extends Model
{
    use HasFactory, TracksUser;

    protected $table = 'exhibitors_suppliers_sales';

    protected $fillable = [
        'fair_code',
        'ff_code',
        'country_destination',
        'co_buyer_name',
        'sub_category_id',
        'remarks',
        'sales_type',
        'type_of_purchaser_buyer',
        'booked',
        'date_of_sale',
        'under_negotiation',
    ];

    protected $casts = [
        'date_of_sale' => 'date',
        'booked' => 'decimal:2',
        'under_negotiation' => 'decimal:2',
    ];

    protected $appends = [
        'sales_type_label',
    ];


    public function getSalesTypeLabelAttribute()
    {
        return SalesTypeStatus::label($this->sales_type);
    }

    public function sub_category()
    {
        return $this->belongsTo(
            SubCategory::class,
            'sub_category_id',
            'id'
        );
    }

    public function sub_category_all()
    {
    return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id')
        ->withoutGlobalScope('subcategory_active');
    }

    public function event(){
        return $this->belongsTo(Event::class,'fair_code','fair_code');
    }

public function exhibitor()
{
    return $this->belongsTo(
        Exhibitor::class,
        'ff_code', 
        'uid'     
    );
}
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'ff_code',
            'id'
        );
    }

        public function country()
    {
        return $this->belongsTo(
            Countries::class,
            'country_destination',
            'id'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function updatedBy()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }
}