<?php

namespace App\Models;

use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\ParticipationBoothSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'exhibitors';

    protected $fillable = [
        'uid',
        'fair_code',
        'exhibitor_type',
        'last_participated_year',
        'start_up',
        'fascia_name',
        'co_name',
        'co_details',
        'mission_statement',
        'env_conservation',
        'co_email',
        'slug',
        'co_email',
        'directory_name',
        'phone_country_code',
        'phone_area_code',
        'phone_no',
        'mobile_country_code',
        'mobile_no',
        'website',
        'year_established',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'other_social',
        'fa_country',
        'fa_state',
        'fa_city',
        'fa_zipcode',
        'fa_region',
        'fa_street',
        'fa_same_as_moa',
        'moa_country',
        'moa_state',
        'moa_city',
        'moa_zipcode',
        'moa_region',
        'moa_street',
        'business_type_id',
        'company_size_id',
        'annual_sales_volume_id',
        'direct_workers',
        'indirect_workers',
        'target_country_export_1',
        'target_country_export_2',
        'target_country_export_3',
        'organization_type_id',
        'industry_rep',
        'ir_country_exporting_1',
        'ir_country_exporting_2',
        'ir_country_exporting_3',
        'product_promoted',
        'banner_size_id',
        'received_latest_updates',
        'reviewed_by',
        'approved_by',
        'onhold_by',
        'disapproved_by',
        'updated_by',
        'added_by'
    ];

    const EXHIBITOR_TYPE_NEW = 1;
    const EXHIBITOR_TYPE_RETURNING = 2;

    const LABEL_EXHIBITOR_TYPE_NEW = 'New Exhibitor';
    const LABEL_EXHIBITOR_TYPE_RETURNING = 'Returning Exhibitor';

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
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

    public function adder()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function factory_country()
    {
        return $this->belongsTo(Countries::class, 'fa_country', 'id');
    }

    public function main_country()
    {
        return $this->belongsTo(Countries::class, 'moa_country', 'id');
    }

    public function country_target_buyer_export_1()
    {
        return $this->belongsTo(Countries::class, 'target_country_export_1', 'id');
    }

    public function country_target_buyer_export_2()
    {
        return $this->belongsTo(Countries::class, 'target_country_export_2', 'id');
    }

    public function country_target_buyer_export_3()
    {
        return $this->belongsTo(Countries::class, 'target_country_export_3', 'id');
    }

    public function country_exporting_to_1()
    {
        return $this->belongsTo(Countries::class, 'ir_country_exporting_1', 'id');
    }

    public function country_exporting_to_2()
    {
        return $this->belongsTo(Countries::class, 'ir_country_exporting_2', 'id');
    }

    public function country_exporting_to_3()
    {
        return $this->belongsTo(Countries::class, 'ir_country_exporting_3', 'id');
    }

    public function business_registration_type()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id', 'id');
    }

    public function company_size()
    {
        return $this->belongsTo(CompanySize::class, 'company_size_id', 'id');
    }

      public function target_buyer()
    {
        return $this->belongsTo(TargetBuyer::class, 'uid', 'id');
    }


    public function annual_sales_volume()
    {
        return $this->belongsTo(AnnualSalesVolume::class, 'annual_sales_volume_id', 'id');
    }

    public function nature_business()
    {
        return $this->belongsTo(NatureBusiness::class, 'nature_business_id', 'id');
    }

    public function organization_type()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id');
    }

    public function banner_size()
    {
        return $this->belongsTo(BannerSize::class, 'banner_size_id', 'id');
    }

    public function participationSelections()
    {
        return $this->hasMany(
            ParticipationBoothSelection::class,
            'ff_code',
            'uid'            
        );
    }

    public function scopeParticipationSelectionsFairCode($query, $fair_code)
{
    return $query->whereHas('participationSelections', function ($subquery) use ($fair_code) {
        $subquery->where('fair_code', $fair_code);
    });
}

    public function attendances()
{
    // Each exhibitor's user_id (uid) links to multiple attendances
    return $this->hasMany(ExhibitorAttendance::class, 'user_id', 'uid');
}

public function attendancesForFair()
{
    return $this->hasMany(ExhibitorAttendance::class, 'user_id', 'uid')
                ->whereColumn('fair_code', 'exhibitors.fair_code');
}

public function attendanceForOwnFair()
{
    return $this->hasOne(ExhibitorAttendance::class, 'user_id', 'uid')
                ->whereColumn('fair_code', 'exhibitors.fair_code');
}

public function conformes()
{
    return $this->hasMany(Conforme::class, 'ff_code', 'uid');
}

public static function getExhibitorTypeLabel($type)
{
    switch ((int) $type) {
        case self::EXHIBITOR_TYPE_NEW:
            return self::LABEL_EXHIBITOR_TYPE_NEW;

        case self::EXHIBITOR_TYPE_RETURNING:
            return self::LABEL_EXHIBITOR_TYPE_RETURNING;

        default:
            return '-';
    }
}

}
