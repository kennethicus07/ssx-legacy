<?php

namespace App\Models;

use App\Models\Buyer\BuyerAttendance;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\PickTopic;
use App\Models\Supplier\PitchingSessionCategoriesSelections;
use App\Models\Supplier\ExhibitorSdg;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'buyerclass',
        'password',
        'password_unhash',
        'reg_token',
        'reset_password_token',
        'user_group',
        'data_from',
        'masthead',
        'logo',
        'solution_type',
        'emaiL_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group', 'id');
    }

    public function exhibitor()
    {
        return $this->hasMany(Exhibitor::class, 'uid', 'id');
    }

    public function exhibitorForFair($fair_code)
    {
    return $this->exhibitor()->where('fair_code', $fair_code)->first();
    }
    
    public function latestExhibitor()
    {
    return $this->hasOne(Exhibitor::class, 'uid', 'id')->latestOfMany('created_at');
    }

    public function exhibitorAttendances()
{
    return $this->hasMany(ExhibitorAttendance::class, 'user_id', 'id');
}

public function exhibitorAttendanceForFair($fair_code)
{
    return $this->exhibitorAttendances()
                ->where('fair_code', $fair_code)
                ->first();
}

    public function buyer()
    {
        return $this->hasMany(Buyer::class, 'uid', 'id');
    }

     public function buyerForFair($fair_code)
    {
    return $this->buyer()->where('fair_code', $fair_code)->first();
    }
    
    public function latestBuyer()
    {
    return $this->hasOne(Buyer::class, 'uid', 'id')->latestOfMany('created_at');
    }

    public function buyerAttendances()
{
    return $this->hasMany(BuyerAttendance::class, 'user_id', 'id');
}
public function buyerAttendanceForFair($fair_code)
{
    return $this->buyerAttendances()
                ->where('fair_code', $fair_code)
                ->first();
}

   

    public function business_owner()
    {
        return $this->hasOne(ExhibitorBusinessOwner::class, 'uid', 'id');
    }

     public function businessOwnerForFair($fairCode)
{
    return $this->hasOne(ExhibitorBusinessOwner::class, 'uid', 'id')
    ->where('fair_code', $fairCode);
}

    public function business_contact_person()
    {
        return $this->hasOne(ExhibitorBusinessContactPerson::class, 'uid', 'id');
    }

      public function businessContactPersonForfair($fairCode)
    {
        return $this->hasOne(ExhibitorBusinessContactPerson::class, 'uid', 'id')     ->where('fair_code', $fairCode);
    }

    public function document()
    {
        return $this->hasOne(ExhibitorDocument::class, 'uid', 'id');
    }

    public function exhibitorDocumentFor($fairCode)
    {
    return $this->hasOne(ExhibitorDocument::class, 'uid', 'id')
    ->where('fair_code', $fairCode);
    }

    public function certification()
    {
        return $this->hasMany(ExhibitorCertification::class, 'uid', 'id');
    }

       public function certificationForFair($fairCode)
    {
        return $this->hasMany(ExhibitorCertification::class, 'uid', 'id')->where('fair_code', $fairCode);
    }

      public function pitchingSelectionsForFair($fairCode)
    {
        return $this->hasMany(PitchingSessionCategoriesSelections::class, 'ff_code', 'id')->where('fair_code', $fairCode);
    }

    public function sdg(){
        return $this->hasMany(ExhibitorSdg:: class, 'uid', 'id');
    }

    public function sdgForFair($fair_code){
        return $this->hasMany(ExhibitorSdg::class, 'uid', 'id')->where('fair_code', $fair_code);
    }

    public function on_input_output()
    {
        return $this->hasMany(ExhibitorOnInputOutput::class, 'uid', 'id');
    }

    public function inputOutputForFair($fair_code)
    {
            return $this->hasMany(ExhibitorOnInputOutput::class, 'uid', 'id')
                    ->where('fair_code', $fair_code);
    }

    public function on_production_process()
    {
        return $this->hasMany(ExhibitorOnProductionProcess::class, 'uid', 'id');
    }

    public function productionProcessForFair($fair_code)
{
      return $this->hasMany(ExhibitorOnProductionProcess::class, 'uid', 'id')->where('fair_code', $fair_code);
}

    public function category_subcategory()
    {
        return $this->hasMany(ExhibitorBuyerCategorySubCategory::class, 'uid', 'id');
    }
    public function categorySubcategoryForFair($fair_code)
{
    return $this->hasMany(ExhibitorBuyerCategorySubCategory::class, 'uid', 'id')
                ->where('fair_code', $fair_code);
}


    public function nature_business()
    {
        return $this->hasMany(ExhibitorBuyerNatureBusiness::class, 'uid', 'id');
    }

public function exhibitorBuyerNatureBusinessForFair($fair_code)
{
    return $this->hasMany(ExhibitorBuyerNatureBusiness::class, 'uid', 'id')
                ->where('fair_code', $fair_code)
                ->with('natureBusiness'); // eager 
}

    public function target_buyer()
    {
        return $this->hasMany(ExhibitorTargetBuyer::class, 'uid', 'id');
    }
public function exhibitorTargetBuyersForFair($fair_code)
{
    return $this->hasMany(ExhibitorTargetBuyer::class, 'uid', 'id')
                ->where('fair_code', $fair_code)
                ->with('natureBusiness'); // eager 
}


    public function participation_goal()
    {
        return $this->hasMany(BuyerParticipatonGoal::class, 'uid', 'id');
    }

    public function learn_about_event()
    {
        return $this->hasMany(BuyerLearnAboutEvent::class, 'uid', 'id');
    }


    public function topic_rank()
    {
        return $this->hasMany(ExhibitorTopicRank::class, 'uid', 'id');
    }

        public function topic_pick()
    {
        return $this->hasMany(PickTopic::class, 'uid', 'id');
    }

    public function topicPicksForFair($fair_code)
    {
    return $this->hasMany(PickTopic::class, 'uid','id')
                ->where('fair_code', $fair_code)->with('focus_topic');
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'uid', 'id');
    }

    public function participation_booth_selection()
    {
        return $this->belongsTo(User::class, 'ff_code', 'id');
    }

  public function isVeryImportantBuyer(): bool
{

    return $this->buyerclass == 1;
}

public function reviewedConferences()
{
    return $this->hasMany(SSXConference::class, 'review_by', 'id');
}

public function billedConferences()
{
    return $this->hasMany(SSXConference::class, 'billing_by', 'id');
}


}
