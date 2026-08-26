<?php

namespace App\Http\Controllers;

use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Buyer\BuyerAttendance;
use App\Models\Conforme;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Meta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Meta::title(env('APP_NAME'));
        // Meta::set('robots', env('META_ROBOTS'));
        // Meta::set('description', 'SSX is an online portal for you to learn about the latest sustainability practices and source sustainable solutions for your businesses from international providers.');
        // Meta::set('author', 'Center for International Trade Expositions and Missions');
        // Meta::set('image', '');
    }

    protected function check_file_exist($url) {
        if (Storage::disk('local')->exists($url)) {
           return 'exists';
        } else {
            return 'not_exists';
        }    
    }

    protected function citemAPICheckEmailExist($email, $type) 
    {
        if ($type === 'exhibitor') {
            $url = env('SSX_API_URL').'/ctm_exhibitors/email/'.$email;
        } else {
            $url = env('SSX_API_URL').'/buyers/email/'.$email;
        }

        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->get($url);

        $results = $response->json();

        if ($results['status'] === 'success') {
            if (empty($results['data'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    protected function citemAPIValidateStatus($email, $status, $type)
    {
        if ($type === 5) {
            $url = env('SSX_API_URL').'/validate_exhibitor/email/'.$email;
            $log_name = 'citem-api-supplier-validate-status';
        } elseif ($type === 3) {
            $url = env('SSX_API_URL').'/validate_buyer/email/'.$email;
            $log_name = 'citem-api-buyer-validate-status';
        } else {
            $url = '';
            $log_name = '';
        }

        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->asForm()->patch($url, [
            'validation_status' => $status
        ]);
        
        activity($log_name)
            ->withProperties(['email' => $email])
            ->log($response->body());

        return true;
    }

    protected function citemAPICreate($id)
    {
        $user = User::find($id);
        
        if (!empty($user)) {
            $arr_data = [];
            $url = '';
            $log_name = '';

            // Handle Exhibitor (user_group 5)
            if ($user->user_group === 5) {
                $url = env('SSX_API_URL').'/exhibitors';
                $log_name = 'citem-api-create-supplier';
                $arr_data = [
                    'cont_per_fn' => '',
                    'cont_per_ln' => '',
                    'mi' => '',
                    'title' => '',
                    'co_name' => $user->name,
                    'webpage' => '',
                    'co_email' => $user->email,
                    'reference_id' => $user->id,
                    'user_agreement' => 'Yes'
                ];
            }
            // Handle Buyer (user_group 3)
            elseif ($user->user_group === 3) {
                $url = env('SSX_API_URL').'/buyers';
                $log_name = 'citem-api-create-buyer';
                $arr_data = [
                    'cont_per_fn' => '',
                    'cont_per_ln' => '',
                    'country' => '',
                    'mi' => '',
                    'title' => '',
                    'co_name' => $user->co_name,
                    'webpage' => '',
                    'email' => $user->email,
                    'reference_id' => $user->id,
                    'user_agreement' => 'Yes'
                ];
            } else {
                $url = '';
                $log_name = '';
            }

        
            if ($url) {
                $response = Http::withHeaders([
                    'x-api-key' => env('SSX_API_KEY'),
                    'Content-Type' => 'application/json'
                ])->post($url, $arr_data);

                $results = $response->json();

            
                activity($log_name)
                    ->withProperties(['user_id' => $user->id])
                    ->log($response->body());

        
                if ($results['status'] === 'success') {
                
                    $status = 'pending';

                
                    $this->citemAPIValidateStatus($user->email, $status, $user->user_group);
                }
            }
        }

        return true;
    }

    protected function citemAPICreateExhibitorAttendanceForFair($user_id, $fair_code){
    $user = User::find($user_id);
    if (!$user) {
        return false;
    }

    // Get attendance info
    $attendance = ExhibitorAttendance::where('user_id', $user->id)
        ->where('fair_code', $fair_code)
        ->first();

    if (!$attendance) {
        return false;
    }

   
    $data = [
        'reference_id'                  => $user->id,
        'fair_code'                     => $fair_code,
        'status'                        => 'incomplete',
        'conference_response'           => '',
        'sponsorship_response'          => '',
        'participation_type'            => '',    
        'registration_agreement_status' => '',          
        'privacy_policy_status'         => '',          
        'information_sharing_status'    => '',          
        'conforme_review'             => '',       
    ];



    $url = env('SSX_API_URL') . '/exhibitors/fair'; 
    $logName = 'citem-api-create-supplier-fair';

    try {
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'status'    => $response->status(),
            ])
            ->log($response->body());

        $results = $response->json();
        if (!empty($results['status']) && $results['status'] === 'success') {
            return true;
        }
    } catch (\Exception $e) {
        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'error'     => $e->getMessage(),
            ])
            ->log('API call failed.');
    }

    return false;
    }

    protected function citemAPIUpdateExhibitorForfair($id, $fair_code)
    {
        $user = User::findOrFail($id);
        $data = [];


        $contact_profile = $user->exhibitorForFair($fair_code);

        if (! $contact_profile) {
            return false;
        }

        $data['reference_id'] = $user->id;
        $data['fair_code']    = $fair_code;
        $data['password'] = $user->password_unhash;
      
        //! COMPANY INFO

        $data['co_email']   = $contact_profile->co_email ?? $user->email;
        $data['co_name']    = $contact_profile->co_name;
        $data['webpage']    = $contact_profile->website;
        $data['brand_name'] = $contact_profile->directory_name;
        $data['tel_off_countrycode'] = $contact_profile->phone_country_code;
        $data['tel_off_areacode']    = $contact_profile->phone_area_code;
        $data['tel_off_number']      = $contact_profile->phone_no;
        $data['co_mobile']           = trim(
            $contact_profile->mobile_country_code.' '.$contact_profile->mobile_no
        );
        $data['facebook'] = ($contact_profile->facebook) ? 'www.facebook.com/'.$contact_profile->facebook : NULL;
        $data['twitter'] = ($contact_profile->twitter) ? 'www.twitter.com/'.$contact_profile->twitter : NULL;
        $data['instagram'] = ($contact_profile->instagram) ? 'www.instagram.com/'.$contact_profile->instagram : NULL;
        $data['linkedin'] = ($contact_profile->linkedin) ? 'www.linked.com/in/'.$contact_profile->linkedin : NULL;
        $data['social_others'] = ($contact_profile->other_social) ? $contact_profile->other_social : NULL;
        $data['foreignlocal'] = $contact_profile->business_type_id
        ? ($contact_profile->business_registration_type->name ?? null)
        : null;


        //! ADDRESS

        if($contact_profile->main_country)
            {
                $data['country'] = $contact_profile->main_country->name ?: NULL;
            }
            
        $data['province'] = $contact_profile->moa_state;
        $data['add_st']   = $contact_profile->moa_street;
        $data['add_city'] = $contact_profile->moa_city;
        $data['zipcode']  = $contact_profile->moa_zipcode;
        $data['region']   = $contact_profile->moa_region;
  


        //! FACTORY ADDRESS
        
        if(!empty($contact_profile->factory_country))
        {
            $data['fact_country'] = $contact_profile->factory_country->name ?: NULL;
        }

        $data['fact_province'] = $contact_profile->fa_state;
        $data['fact_st']       = $contact_profile->fa_street;
        $data['fact_city']     = $contact_profile->fa_city;
        $data['fact_zipcode']  = $contact_profile->fa_zipcode;
        $data['fact_region']   = $contact_profile->fa_region;
      

        //! BUSINESS PERSON

        $data['start_up'] = $contact_profile->start_up === 1 ? 'Yes' : 'No';  
        $data['company_size'] = $contact_profile->company_size_id ?: NULL;
        $data['annual_sales'] = $contact_profile->annual_sales_volume_id ?: NULL;
        $data['direct_workers'] = $contact_profile->direct_workers ?: NULL;
        $data['indirect_workers'] = $contact_profile->indirect_workers ?: NULL;
        $data['business_ownership'] = $contact_profile->organization_type_id ?: NULL;
        

        //! CONTACT PERSON

        $bo = $user->business_owner()
            ->where('fair_code', $fair_code)
            ->first();

        if ($bo) {
            $data['cont_per_fn'] = $bo->fname;
            $data['cont_per_ln'] = $bo->lname;
            $data['mi']          = $bo->mi;
            $data['title']       = $bo->designation;
            $data['owner_mobile']= $bo->country_code.' '.$bo->mobile_no;
            $data['owner_email'] = $bo->email;
        }

        $bcp = $user->business_contact_person()
            ->where('fair_code', $fair_code)
            ->first();

        if ($bcp) {
            $data['rep_cont_per_fn'] = $bcp->fname;
            $data['rep_cont_per_ln'] = $bcp->lname;
            $data['rep_mi']          = $bcp->mi;
            $data['rep_title']       = $bcp->designation;
            $data['rep_mobile']      = $bcp->country_code.' '.$bcp->mobile_no;
            $data['rep_email']       = $bcp->email;
        }

        $data['nature_of_business'] = $user->nature_business()
            ->where('fair_code', $fair_code)
            ->pluck('remarks')
            ->implode('|');

        if ($contact_profile->industry_rep === 1) {
            $exportMarkets = array_filter([
                optional($contact_profile->country_exporting_to_1)->name,
                optional($contact_profile->country_exporting_to_2)->name,
                optional($contact_profile->country_exporting_to_3)->name,
            ]);

            $data['export_market'] = $exportMarkets
                ? implode('|', $exportMarkets)
                : null;
        }

        if (!empty($contact_profile->target_country_export_1)) {
            $targetCountries = array_filter([
                optional($contact_profile->country_target_buyer_export_1)->name,
                optional($contact_profile->country_target_buyer_export_2)->name,
                optional($contact_profile->country_target_buyer_export_3)->name,
            ]);

        $data['target_countries'] = $targetCountries
            ? implode('|', $targetCountries)
            : null;
        }

        $data['target_buyers'] = $user->target_buyer()
            ->where('fair_code', $fair_code)
            ->pluck('remarks')
            ->implode('|');

        $data['certification'] = $user->certification()
            ->where('fair_code', $fair_code)
            ->pluck('remarks')
            ->implode('|');

        $data['products_promoted'] = $contact_profile->product_promoted ?? null;

        $data['prod_sub_category'] = $user->category_subcategory()
            ->where('fair_code', $fair_code)
            ->pluck('sub_category_remarks')
            ->implode('|');

        $data['product_char_inputoutput'] = $user->on_input_output()
            ->where('fair_code', $fair_code)
            ->pluck('product_char_inputoutput.item_code')
            ->implode('|');

        $data['product_char_prod_process'] = $user->on_production_process()
            ->where('fair_code', $fair_code)
            ->pluck('product_char_prod_process.item_code')
            ->implode('|');


        $document = $user->document()
        ->where('fair_code', $fair_code)
        ->first();

        if ($document) {
            $data['sec_dti_doc'] = $document->dti_sec 
                ? public_path('storage/documents/'.$document->dti_sec)
                : null;

            $data['bir_reg_doc'] = $document->bir 
                ? public_path('storage/documents/'.$document->bir)
                : null;

            $data['license_cert_doc'] = $document->lto 
                ? public_path('storage/documents/'.$document->lto)
                : null;

            $data['brochure_etc_doc'] = $document->cpr 
                ? public_path('storage/documents/'.$document->cpr)
                : null;

            $data['other_food_doc'] = $document->other_food_certificate 
                ? public_path('storage/documents/'.$document->other_food_certificate)
                : null;

            $data['institutional_catalog_doc'] = $document->institutional_catalog 
                ? public_path('storage/documents/'.$document->institutional_catalog)
                : null;

            $data['business_certification_doc'] = $document->business_certification 
                ? public_path('storage/documents/'.$document->business_certification)
                : null;

            $data['food_or_environmental_certification_doc'] = $document->food_or_environmental_certification 
                ? public_path('storage/documents/'.$document->food_or_environmental_certification)
                : null;
        }


        if(!empty($contact_profile->received_latest_updates)) {
            if ($contact_profile->received_latest_updates === 1) {
                $data['subscription'] = 'Yes';
            } else {
                $data['subscription'] = 'No';
            }
        }
        

        //! API

        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->asForm()->patch(
            env('SSX_API_URL').'/exhibitors/email/'.$contact_profile->co_email.'/fair/'.$fair_code,
            $data
        );

        activity('citem-api-update-supplier')
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code
            ])
            ->log($response->body());

        return true;
    }

    protected function citemAPIValidateExhibitorAttendanceStatusForFair($user_id, $fair_code, $status)
{
    $user = User::find($user_id);
    if (!$user) {
        return false;
    }

    $attendance = ExhibitorAttendance::where('user_id', $user->id)
        ->where('fair_code', $fair_code)
        ->first();

    if (!$attendance) {
        return false;
    }


    $participationType = '';
    if (!empty($attendance->participation_type)) {
        $participationType = $attendance->participation_type == 1 ? 'individual' : 'group';
    }

    // Define status mapping
    $statusMap = [
        0 => 'incomplete',
        1 => 'approved',
        2 => 'pending',
        3 => 'reviewed',
        4 => 'onhold',
        5 => 'disapproved',
    ];


    $mappedStatus = isset($attendance->status) ? ($statusMap[$attendance->status] ?? '') : '';

 
    if ($attendance->status == 1) {
        
        if ($attendance->conforme_review == 0) {
            $mappedStatus = 'conforme pending review';
        }
        elseif ($attendance->conforme_review == 1) {
            $mappedStatus = 'approved';
        }
    }

    $conferenceResponse = isset($attendance->conference_response) 
        ? ($attendance->conference_response ? 'Yes' : 'No') 
        : '';

    $sponsorshipResponse = isset($attendance->sponsorship_response) 
        ? ($attendance->sponsorship_response ? 'Yes' : 'No') 
        : '';

    $registrationAgreement = isset($attendance->registration_agreement_status) 
        ? ($attendance->registration_agreement_status ? 'Yes' : 'No') 
        : '';

    $privacyPolicy = isset($attendance->privacy_policy_status) 
        ? ($attendance->privacy_policy_status ? 'Yes' : 'No') 
        : '';

    $informationSharing = isset($attendance->information_sharing_status) 
        ? ($attendance->information_sharing_status ? 'Yes' : 'No') 
        : '';

    $conformeReview = isset($attendance->conforme_review) 
        ? ($attendance->conforme_review ? 'Yes' : 'No') 
        : '';


    $data = [
        'reference_id'                  => $user->id,
        'fair_code'                     => $fair_code,
        'status'                        => $mappedStatus,
        'conference_response'           => $conferenceResponse,
        'sponsorship_response'          => $sponsorshipResponse,
        'participation_type'            => $participationType,
        'registration_agreement_status' => $registrationAgreement,
        'privacy_policy_status'         => $privacyPolicy,
        'information_sharing_status'    => $informationSharing,
        'conforme_review'             => $conformeReview,
    ];

    //! API
    $url = env('SSX_API_URL') . '/validate_exhibitor/email/'.$user->email.'/fair/'.$fair_code;
    $logName = 'citem-api-validate-supplier-attendance';

    try {
       
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->asForm()->patch($url, $data);

       
        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'status'    => $status
            ])
            ->log($response->body());

        return true;
    } catch (\Exception $e) {
      
        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'error'     => $e->getMessage()
            ])
            ->log('API call failed.');

        return false;
    }
    }

    protected function citemAPICreateBuyerAttendanceForFair($user_id, $fair_code)
{
    $user = User::find($user_id);
    if (!$user) {
        return false;
    }

    $attendance = BuyerAttendance::where('user_id', $user->id)
        ->where('fair_code', $fair_code)
        ->first();

    if (!$attendance) {
        return false;
    }

   
    $data = [
        'reference_id'                  => $user->id,
        'fair_code'                     => $fair_code,
        'status'                        => 'incomplete', 
        'registration_agreement_status' => '',          
        'privacy_policy_status'         => '',          
        'information_sharing_status'    => '',              
    ];



    $url = env('SSX_API_URL') . '/buyers/fair'; 
    $logName = 'citem-api-create-buyer-fair';

    try {
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'status'    => $response->status(),
            ])
            ->log($response->body());

        $results = $response->json();
        if (!empty($results['status']) && $results['status'] === 'success') {
            return true;
        }
    } catch (\Exception $e) {
        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'error'     => $e->getMessage(),
            ])
            ->log('API call failed.');
    }

    return false;
    }

    protected function citemAPIUpdateBuyerForFair($id, $fair_code)
{
    $user = User::findOrFail($id);
    $data = [];
    $contact_profile = $user->buyerForFair($fair_code); 

    if (!$contact_profile) {
        return false;
    }

    $data['reference_id'] = $user->id;
    $data['email'] = $user->email;
    $data['password'] = $user->password_unhash;
    $data['cont_per_fn'] = $contact_profile->fname;
    $data['cont_per_ln'] = $contact_profile->lname;
    $data['mi'] = $contact_profile->mi;
    $data['country'] = optional($contact_profile->b_country)->name;
    $data['continent'] = optional($contact_profile->b_country)->continent;
    $data['co_name'] = $contact_profile->co_name;
    $data['organization_type'] = optional($contact_profile->organization_type)->name;

    if (!empty($contact_profile->company_annual_sale_id)) {
        $data['annual_sales'] = optional($contact_profile->companyAnnualSaleId)->name;
    }

    
    if (isset($contact_profile->has_ph_business_supplier)) {
        $data['has_ph_business_supplier'] =
            $contact_profile->has_ph_business_supplier == 1 ? 'Yes' : 'No';
    }

   
    $data['ph_supplier_name'] = $contact_profile->ph_supplier_name ?? null;

    
    if (!empty($contact_profile->annual_purchase_from_existing_supplier_id)) {
        $data['annual_purchase_from_existing_supplier'] =
            optional($contact_profile->annualPurchaseFromExistingSupplierId)->name;
    }

    $data['salutation'] = $contact_profile->honorific;


    $natureBusiness = $user->nature_business()
        ->where('fair_code', $fair_code)
        ->pluck('remarks');
    if ($natureBusiness->isNotEmpty()) {
        $data['representation'] = $natureBusiness->implode('|');
    }

 
    $data['user_agreement'] = 'Yes';
    $data['title'] = $contact_profile->designation;
    $data['webpage'] = $contact_profile->website;
    $data['add_st'] = $contact_profile->street;
    $data['add_city'] = $contact_profile->city;
    $data['region'] = $contact_profile->region;
    $data['zipcode'] = $contact_profile->zipcode;
    $data['province'] = $contact_profile->state;
    $data['tel_off'] = $contact_profile->country_code.' '.$contact_profile->phone_no;
    $data['mobile'] = '';
    $data['nationality'] = '';
    $data['facebook'] = $contact_profile->facebook ? 'www.facebook.com/'.$contact_profile->facebook : null;
    $data['twitter'] = null;
    $data['instagram'] = $contact_profile->instagram ? 'www.instagram.com/'.$contact_profile->instagram : null;
    $data['linkedin'] = $contact_profile->linkedin ? 'www.linked.com/in/'.$contact_profile->linkedin : null;
    $data['social_others'] = $contact_profile->other_social ?? null;

    if ($contact_profile->company_role_id) {
        $data['job_function'] = optional($contact_profile->job_function)->name;
    }

    $data['supplier_info'] = null;
    $data['show_reason'] = null;
    $data['inform_thru'] = null;


    $categories = $user->category_subcategory()
        ->where('fair_code', $fair_code)
        ->get();

    if ($categories->isNotEmpty()) {
        $data['category'] = $categories->pluck('category_remarks')->unique()->implode('|');
        $data['prod_sub_category'] = $categories->pluck('sub_category_remarks')->implode('|');
    }

    $data['interpreter'] = isset($contact_profile->need_interpreter) 
    ? ($contact_profile->need_interpreter === 1 ? 'Yes' : 'No') 
    : ''; 
    $data['arranged_meetings'] = $contact_profile->interested_meeting === 1 ? 'Yes' : 'No';
    $data['y_estab'] = $contact_profile->year_established;

    //! API
    $response = Http::withHeaders([
        'x-api-key' => env('SSX_API_KEY')
    ])->asForm()->patch(
        env('SSX_API_URL').'/buyers/email/'.$user->email.'/fair/'.$fair_code,
        $data
    );

    activity('citem-api-update-buyer-for-fair')
        ->withProperties(['user_id' => $user->id, 'fair_code' => $fair_code])
        ->log($response->body());

    return true;
}

   protected function citemAPIValidateBuyerAttendanceStatusForFair($user_id, $fair_code, $status)
{
    $user = User::find($user_id);
    if (!$user) {
        return false;
    }

    $attendance = ExhibitorAttendance::where('user_id', $user->id)
        ->where('fair_code', $fair_code)
        ->first();

    if (!$attendance) {
        return false;
    }


 

    $statusMap = [
        0 => 'incomplete',
        1 => 'approved',
        2 => 'pending',
        3 => 'reviewed',
        4 => 'onhold',
        5 => 'disapproved',
    ];


    $mappedStatus = isset($attendance->status) ? ($statusMap[$attendance->status] ?? '') : '';

   
    $registrationAgreement = isset($attendance->registration_agreement_status) 
        ? ($attendance->registration_agreement_status ? 'Yes' : 'No') 
        : '';

    $privacyPolicy = isset($attendance->privacy_policy_status) 
        ? ($attendance->privacy_policy_status ? 'Yes' : 'No') 
        : '';

    $informationSharing = isset($attendance->information_sharing_status) 
        ? ($attendance->information_sharing_status ? 'Yes' : 'No') 
        : '';




    $data = [
        'reference_id'                  => $user->id,
        'fair_code'                     => $fair_code,
        'status'                        => $mappedStatus,
        'registration_agreement_status' => $registrationAgreement,
        'privacy_policy_status'         => $privacyPolicy,
        'information_sharing_status'    => $informationSharing,
      
    ];

    //! API
    $url = env('SSX_API_URL') . '/validate_buyer/email/'.$user->email.'/fair/'.$fair_code;
    $logName = 'citem-api-validate-buyer-attendance';

    try {

        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->asForm()->patch($url, $data);


        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'status'    => $status
            ])
            ->log($response->body());

        return true;
    } catch (\Exception $e) {
      
        activity($logName)
            ->withProperties([
                'user_id'   => $user->id,
                'fair_code' => $fair_code,
                'error'     => $e->getMessage()
            ])
            ->log('API call failed.');

        return false;
    }
    }  

    protected function citemAPICreateConforme($user_id, $fair_code)
{
    $user = User::find($user_id);
    if (!$user) {
        activity('citem-api-conforme')
            ->withProperties(['user_id' => $user_id])
            ->log('User not found.');
        return false;
    }

    $conforme = Conforme::where('ff_code', $user_id)
        ->where('fair_code', $fair_code)
        ->latest()
        ->first();

    if (!$conforme) {
        activity('citem-api-conforme')
            ->withProperties(['user_id' => $user_id, 'fair_code' => $fair_code])
            ->log('No Conforme record found.');
        return false;
    }

    $data = [
        'reference_id'   => $user->id,
        'fair_code'      => $fair_code,
        'email_token'    => $conforme->email_token,
        'recipient_email'=> $conforme->recipient_email,
        'noa_file'       => $conforme->noa_file,
        'response' => null,
        'date_responded' => null,
        'date_sent' => $conforme->date_sent,    
    ];

    $url = env('SSX_API_URL') . '/conforme';
    $logName = 'citem-api-create-conforme';

    try {
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        $results = $response->json();

        activity($logName)
            ->withProperties([
                'user_id' => $user->id,
                'fair_code' => $fair_code,
                'response_status' => $response->status(),
            ])
            ->log($response->body());

        return !empty($results['status']) && $results['status'] === 'success';
    } catch (\Exception $e) {
        activity($logName)
            ->withProperties([
                'user_id' => $user->id,
                'fair_code' => $fair_code,
                'error' => $e->getMessage(),
            ])
            ->log('API call failed.');

        return false;
    }
    }

    protected function citemAPIUpdateConforme($token)
    {
        $conforme = Conforme::where('email_token', $token)->first();

        if (!$conforme) {
            activity('citem-api-conforme')
                ->withProperties(['token' => $token])
                ->log('No Conforme record found.');
            return false;
        }

        if ($conforme->response === null) {
            activity('citem-api-conforme')
                ->withProperties(['ff_code' => $conforme->ff_code])
                ->log('Conforme not yet responded. Skipping API call.');
            return false;
        }

        $dateResponded = $conforme->date_responded ? $conforme->date_responded->format('Y-m-d H:i:s') : null;

        $data = [
            'response'       => $conforme->response == 1 ? 'approved' : 'rejected',
            'date_responded' => $dateResponded,
        ];

        $url = env('SSX_API_URL') . '/conforme/' . $conforme->email_token;

        try {
            $response = Http::withHeaders([
                'x-api-key' => env('SSX_API_KEY'),
                'Content-Type' => 'application/json'
            ])->patch($url, $data);

            activity('citem-api-conforme')
                ->withProperties([
                    'ff_code' => $conforme->ff_code,
                    'token' => $token,
                    'response' => $conforme->response
                ])
                ->log($response->body());

            return true;
        } catch (\Exception $e) {
            activity('citem-api-conforme')
                ->withProperties([
                    'ff_code' => $conforme->ff_code,
                    'token' => $token,
                    'error' => $e->getMessage()
                ])
                ->log('API call failed.');

            return false;
        }
    }
}
