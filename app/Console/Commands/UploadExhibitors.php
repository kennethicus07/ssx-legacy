<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SubCategory;
use Carbon\Carbon;

class UploadExhibitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:exhibitors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getTotalRecords();

        $pager = DB::table('api_page')->where('export', '=', 'exhibitor')->where('status', 1)->latest()->first();
        if (!empty($pager->current_page)) {
            $offset = $pager->current_page;
        } else {
            $offset = 0;
        }
        
        $total_records_per_page = 5;
        
        if ($offset <= $pager->total_records) {
            $url = env('SSX_API_URL').'/proj_exhibitors?limit='.$total_records_per_page.'&offset='.$offset;
            //$url = env('SSX_API_URL').'/proj_exhibitors';
            $response = Http::withHeaders([
                'x-api-key' => env('SSX_API_KEY')
            ])->get($url);
        
            $result = $response->object();
            // print_r($result);
            // exit;
            if ($result->status == 'success') {
                if (!empty($result->data)) {
                    foreach ($result->data as $data) {
                        if (DB::table('users')->where('email', '=', $data->co_email)->doesntExist()) {
                            $user = new User;
                            $user->name = $data->co_name;
                            $user->email = $data->co_email;
                            $user->password = NULL;
                            $user->status = 2;
                            $user->user_group = 2;
                            $user->data_from = 'api';
                            $user->save();
                        } else {
                            $user = User::where('email', '=', $data->co_email)->first();
                        }
                        //COMPANY SIZE
                        $company_size = NULL;
                        if (!empty($data->company_size)) {
                            $sql_company_size = DB::table('company_sizes')->where('name', '=', $data->company_size)->first();
                            if (!empty($sql_company_size)) {
                                $company_size = $sql_company_size->id;
                            }
                        }
                        //ANNUAL SALES VOLUME
                        $annual_sales = NULL;
                        if (!empty($data->annual_sales)) {
                            $sql_annual_sales = DB::table('annual_sales_volumes')->where('name', '=', $data->annual_sales)->first();
                            if (!empty($sql_annual_sales)) {
                                $annual_sales = $sql_annual_sales->id;
                            }
                        }
                        //ORGANIZATIONAL TYPE
                        $org_type = NULL;
                        if (!empty($data->type_of_org)) {
                            $sql_org_type = DB::table('organization_types')->where('name', '=', $data->type_of_org)->first();
                            if (!empty($sql_org_type)) {
                                $org_type = $sql_org_type->id;
                            }
                        }
                        //EXPORTING COUNTRIES TO
                        $arr_exporting_countries = [];
                        if (!empty($data->countries_exporting_to)) {
                            $country_country = 1;
                            foreach ($data->countries_exporting_to[0] as $export_country) {
                                $country = DB::table('countries')->where('name', '=', $export_country)->first();
                                if (!empty($country->id)) {
                                    $arr_exporting_countries['ir_country_exporting_'.$country_country++] = $country->id;
                                }
                            }
                        }
                        //BANNER
                        $banner = NULL;
                        if (!empty($data->banner)) {
                            $sql_banner = DB::table('banner_sizes')->where('item_code', '=', $data->banner)->first();
                            if (!empty($sql_banner)) {
                                $banner = $sql_banner->id;
                            }
                        }
                        // SUPPLIER INFO
                        $fb_clean_url = NULL;
                        if (!empty($data->social_media->facebook)) {
                            $arr_replace_fb = ['www.faceboook.com','facebook.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.facebook.com/','https://facebook.com/','www.facebook.com/','https://m.facebook.com/','m.facebook.com/','http://fb.com/','fb.com/','https://web.facebook.com/','web.facebook.com/','/'];
                            $fb_clean_url = str_replace($arr_replace_fb, "", $data->social_media->facebook);
                        }
                        $twitter_clean_url = NULL;
                        if (!empty($data->social_media->twitter)) {
                            $arr_replace_twitter = ['www.twitter.com','twitter.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.twitter.com/','https://twitter.com/','www.twitter.com/','https://m.twitter.com/','m.twitter.com/','https://web.twitter.com/','web.twitter.com/','/'];
                            $twitter_clean_url = str_replace($arr_replace_twitter, "", $data->social_media->twitter);
                        }
                        $ig_clean_url = NULL;
                        if (!empty($data->social_media->instagram)) {
                            $arr_replace_ig = ['www.instagram.com','instagram.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.instagram.com/','https://instagram.com/','www.instagram.com/','https://m.instagram.com/','m.instagram.com/','https://web.instagram.com/','web.instagram.com/','INSTAGRAM.com','/'];
                            $ig_clean_url = str_replace($arr_replace_ig, "", $data->social_media->instagram);
                        }
                        $arr_exhibitor = [
                            'directory_name' => $data->directory_name,
                            'co_name' => $data->co_name,
                            'slug' => Str::slug($data->co_name, '-'),
                            'co_details' => NULL,
                            'mission_statement' => NULL,
                            'env_conservation' => NULL,
                            'phone_country_code' => NULL,
                            'phone_area_code' => NULL,
                            'phone_no' => $data->phone_number,
                            'mobile_country_code' => NULL,
                            'mobile_no' => $data->co_mobile,
                            'website' => $data->webpage,
                            'year_established' => $data->year_established,
                            'facebook' => $fb_clean_url,
                            'twitter' => $twitter_clean_url,
                            'instagram' => $ig_clean_url,
                            'linkedin' =>  ($data->social_media->linkedin) ? Str::replace('https://www.linked.com/in/', '', $data->social_media->linkedin) : '',
                            'other_social' => $data->social_media->others,
                            'fa_country' => $this->getCountryCode($data->factory_address->country),
                            'fa_state' => $data->factory_address->province,
                            'fa_city' => $data->factory_address->city,
                            'fa_zipcode' => $data->factory_address->zipcode,
                            'fa_region' => $data->factory_address->region,
                            'fa_street' => $data->factory_address->street,
                            'fa_same_as_moa' => 0,
                            'moa_country' => $this->getCountryCode($data->office_address->country),
                            'moa_state' => $data->office_address->province,
                            'moa_city' => $data->office_address->city,
                            'moa_zipcode' => $data->office_address->zipcode,
                            'moa_region' => Str::upper($data->office_address->region),
                            'moa_street' => $data->office_address->street,
                            'business_type_id' => ($data->business_registration == 'Local') ? 1 : 2,
                            'company_size_id' => $company_size,
                            'annual_sales_volume_id' => $annual_sales,
                            'organization_type_id' => $org_type,
                            'direct_workers' => $data->direct_workers,
                            'indirect_workers' => $data->indirect_workers,
                            'banner_size_id' => $banner
                        ];
                        $arr_merge = array_merge($arr_exhibitor, $arr_exporting_countries);
                        $user->exhibitor()->updateOrCreate(
                            [
                                'co_email' => $data->co_email
                            ],$arr_merge
                            
                        );
                        //BUSINESS OWNER INFO
                        if (!empty($data->business_owner)) {
                            $arr_business_owner = [
                                'fname' => $data->business_owner->firstname,
                                'lname' => $data->business_owner->lastname,
                                'mi' => Str::limit($data->business_owner->mi, 1, ''),
                                'designation' => $data->business_owner->title,
                                'email' => $data->business_owner->email,
                                'country_code' => NULL,
                                'mobile_no' => $data->business_owner->mobile
                            ];
                            $user->business_owner()->updateOrCreate(
                                ['uid' => $user->id],$arr_business_owner
                            );
                        }
                        //CONTACT PERSON INFO
                        if (!empty($data->contact_person)) {
                            $arr_contact_person = [
                                'fname' => $data->contact_person->firstname,
                                'lname' => $data->contact_person->lastname,
                                'mi' => Str::limit($data->contact_person->mi, 1, ''),
                                'designation' => $data->contact_person->title,
                                'email' => $data->contact_person->email,
                                'country_code' => NULL,
                                'mobile_no' => $data->contact_person->mobile,
                                'same_as_bo' => 0
                            ];
                            $user->business_contact_person()->updateOrCreate(
                                ['uid' => $user->id],$arr_contact_person
                            );
                        }
                        //NATURE BUSINESS
                        if (!empty($data->nature_of_business)) {
                            $user->nature_business()->delete();
                            $exp_nature_business = explode('|', $data->nature_of_business);
                            $sql_nature_business = DB::table('nature_businesses')->whereIn('name', $exp_nature_business)->get();
                            $arr_nature_business = [];
                            foreach ($sql_nature_business as $nb) {
                                if (!empty($sql_nature_business)) {
                                    $arr_nature_business[] = [
                                        'nature_business_id' => $nb->id,
                                        'remarks' => $nb->name
                                    ];
                                }
                            }
                            $user->nature_business()->createMany($arr_nature_business);
                        }
                        //CERTIFICATIONS
                        if (!empty($data->certification)) {
                            $user->certification()->delete();
                            $sql_certifications = DB::table('certifications')->whereIn('name', $data->certification[0])->get();
                            $arr_certifications = [];
                            foreach ($sql_certifications as $cert) {
                                if (!empty($sql_certifications)) {
                                    $arr_certifications[] = [
                                        'certification_id' => $cert->id,
                                        'remarks' => $cert->name
                                    ];
                                }
                            }
                            $user->certification()->createMany($arr_certifications);
                        }
                        //CATEGORY / SUB CATEGORY
                        if (!empty($data->category_offered)) {
                            $user->category_subcategory()->delete();
                            $sql_subcat = SubCategory::whereIn('name', $data->category_offered[0])->get();
                            $arr_subcat = [];
                            foreach ($sql_subcat as $subcat) {
                                $arr_subcat[] = [
                                    'category_id' => $subcat->category_id,
                                    'category_remarks' => $subcat->category->name,
                                    'sub_category_id' => $subcat->id,
                                    'sub_category_remarks' => $subcat->name
                                ];
                            }
                            $user->category_subcategory()->createMany($arr_subcat);
                        }
                        //ON INPUT/OUTPUT
                        if (!empty($data->onInputOutputCode)) {
                            $user->on_input_output()->delete();
                            $sql_input_output = DB::table('on_input_output')->whereIn('item_code', $data->onInputOutputCode[0])->get();
                            $arr_input_ouput = [];
                            foreach ($sql_input_output as $input_output) {
                                $arr_input_ouput[] = [
                                    'input_output_id' => $input_output->id
                                ];
                            }
                            $user->on_input_output()->createMany($arr_input_ouput);
                        }
                        //ON PRODUCTION PROCESS
                        if (!empty($data->onProductionProcessCode)) {
                            $user->on_production_process()->delete();
                            $sql_prod_process = DB::table('on_production_process')->whereIn('item_code', $data->onProductionProcessCode[0])->get();
                            $arr_production_process = [];
                            foreach ($sql_prod_process as $pprocess) {
                                $arr_production_process[] = [
                                    'production_process_id' => $pprocess->id,
                                    'other_certification' => NULL
                                ];
                            }
                            $user->on_production_process()->createMany($arr_production_process);
                        }
                        //TOPIC RANGKING
                        if (!empty($data->focus_ranking)) {
                            $user->topic_rank()->delete();
                            $sql_ranks = DB::table('rank_topics')->whereIn('item_code', $data->focus_ranking[0])->get();
                            $arr_topic_rank = [];
                            foreach ($sql_ranks as $rank_key => $rank) {
                                if ($rank_key >= 1) {
                                    $arr_topic_rank[] = [
                                        'topic_id' => $rank->id,
                                        'rank' => $rank_key
                                    ];
                                }
                            }
                            $user->topic_rank()->createMany($arr_topic_rank);
                        }
                    }
                    DB::table('api_page')->where('id', $pager->id)->update([
                        'url' => $url,
                        'remarks' => 'success'
                    ]);
                } else {
                    DB::table('api_page')->where('id', $pager->id)->update([
                        'url' => $url,
                        'remarks' => 'no record'
                    ]);
                }
            }
        }
        return 0;
    }

    protected function getCountryCode($str)
    {
        $country = DB::table('countries')->where('name', 'like', '%'.$str.'%')->first();
        if (!empty($country)) {
            return $country->id;
        } else {
            return 0;
        }
    }

    protected function getTotalRecords()
    {
        $url = env('SSX_API_URL').'/proj_exhibitors?limit=1&offset=0';
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->get($url);

        $result = $response->object();

        $total_records = 0;
        $offset = 5;

        if ($result->status == 'success') {
            if (!empty($result->paging)) {
                $total_records = $result->paging->total_records;
                
                $pager = DB::table('api_page')->where('export', '=', 'exhibitor')->where('status', 1)->latest()->first();
                if (!empty($pager)) {
                    if ($pager->total_records == $total_records) {
                        $curr_page = $pager->current_page+$offset;
                        DB::table('api_page')->insert(
                            ['export' => 'exhibitor', 'total_records' => $total_records, 'current_page' => $curr_page, 'status' => 1, 'created_at' => Carbon::now()]
                        );
                    } else {
                        DB::table('api_page')->insert(
                            ['export' => 'exhibitor', 'total_records' => $total_records, 'current_page' => 0, 'status' => 1, 'created_at' => Carbon::now()]
                        );
                    }
                } else {
                    DB::table('api_page')->insert(
                        ['export' => 'exhibitor', 'total_records' => $total_records, 'current_page' => 0, 'status' => 1, 'created_at' => Carbon::now()]
                    );
                }    
            }
        }
        return true;
    }
}
