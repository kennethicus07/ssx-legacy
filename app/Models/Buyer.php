<?php

namespace App\Models;

use App\Models\Buyer\AnnualPurchaseExistingSupplier;
use App\Models\Buyer\BuyerAttendance;
use App\Models\Buyer\CompanyAnnualSales;
use App\Models\Supplier\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'buyers';

    protected $fillable = [
        'uid','fair_code', 'co_name', 'co_email', 'slug', 'country', 'city', 'zipcode', 'region', 'street', 'state', 'country_code', 'area_code', 'phone_no', 'website', 'year_established',
        'facebook', 'instagram', 'linkedin', 'other_social', 'company_annual_sale_id','organization_type_id', 'has_ph_business_supplier', 'ph_supplier_name', 'annual_purchase_from_existing_supplier_id', 'honorific', 'fname', 'lname', 'mi', 'designation', 'email', 
        'company_role_id', 'interested_meeting', 'need_interpreter', 'reviewed_by', 'approved_by', 'onhold_by', 'disapproved_by', 'last_update_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }

    public function internal_event()
    {
        return $this->belongsTo(Event::class, 'fair_code', 'fair_code');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function disapprover()
    {
        return $this->belongsTo(User::class, 'disapproved_by', 'id');
    }

    public function onholder()
    {
        return $this->belongsTo(User::class, 'onhold_by', 'id');
    }

    public function last_update()
    {
        return $this->belongsTo(User::class, 'last_update_by', 'id');
    }
    
    public function b_country()
    {
        return $this->belongsTo(Countries::class, 'country', 'id');
    }

    public function organization_type()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id');
    }

    public function job_function()
    {
        return $this->belongsTo(CompanyRole::class, 'company_role_id', 'id');
    }

    public function buyer_attendances()
{
    // Each buyer's user_id (uid) links to multiple attendances
    return $this->hasMany(BuyerAttendance::class, 'user_id', 'uid');
    }

    public function buyerAttendancesForFair()
    {
        return $this->hasMany(BuyerAttendance::class, 'user_id', 'uid')
                    ->whereColumn('fair_code', 'exhibitors.fair_code');
    }

    public function buyerAttendanceForOwnFair()
    {
        return $this->hasOne(BuyerAttendance::class, 'user_id', 'uid')
                    ->whereColumn('fair_code', 'exhibitors.fair_code');
    }

    public function companyAnnualSaleId()
    {
        return $this->belongsTo(CompanyAnnualSales::class, 'company_annual_sale_id)', 'id');
    }

   public function annualPurchaseFromExistingSupplierId(){
     return $this->belongsTo(AnnualPurchaseExistingSupplier::class, 'annual_purchase_from_existing_supplier_id)', 'id');
   }

}
