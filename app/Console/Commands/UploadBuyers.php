<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ParticipationGoal;
use App\Models\SubCategory;
use App\Models\NatureBusiness;
use App\Models\AboutEvent;
use Carbon\Carbon;

class UploadBuyers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:buyers';

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

        $pager = DB::table('api_page')->where('export', '=', 'buyer')->where('status', 1)->latest()->first();
        if (!empty($pager->current_page)) {
            $offset = $pager->current_page;
        } else {
            $offset = 0;
        }
        
        
        $total_records_per_page = 5;

        if ($offset <= $pager->total_records) {
            $url = env('SSX_API_URL').'/proj_buyers?limit='.$total_records_per_page.'&offset='.$offset;
            $response = Http::withHeaders([
                'x-api-key' => env('SSX_API_KEY')
            ])->get($url);
        
            $result = $response->object();
            
            if ($result->status == 'success') {
                if (!empty($result->data)) {
                    foreach ($result->data as $data) {
                        if (DB::table('users')->where('email', '=', $data->company_email)->doesntExist()) {
                            $user = new User;
                            $user->name = Str::upper($data->company);
                            $user->email = Str::lower($data->company_email);
                            $user->password = NULL;
                            $user->status = 2;
                            $user->user_group = 3;
                            $user->data_from = 'api';
                            $user->save();
                        } else {
                            $user = User::where('email', '=', $data->company_email)->first();
                        }

                        $fb_clean_url = NULL;
                        if (!empty($data->facebook)) {
                            $arr_replace_fb = ['www.faceboook.com','facebook.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.facebook.com/','https://facebook.com/','www.facebook.com/','https://m.facebook.com/','m.facebook.com/','http://fb.com/','fb.com/','https://web.facebook.com/','web.facebook.com/','/'];
                            $fb_clean_url = str_replace($arr_replace_fb, "", $data->facebook);
                        }
                        $twitter_clean_url = NULL;
                        if (!empty($data->twitter)) {
                            $arr_replace_twitter = ['www.twitter.com','twitter.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.twitter.com/','https://twitter.com/','www.twitter.com/','https://m.twitter.com/','m.twitter.com/','https://web.twitter.com/','web.twitter.com/','/'];
                            $twitter_clean_url = str_replace($arr_replace_twitter, "", $data->twitter);
                        }
                        $ig_clean_url = NULL;
                        if (!empty($data->instagram)) {
                            $arr_replace_ig = ['www.instagram.com','instagram.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.instagram.com/','https://instagram.com/','www.instagram.com/','https://m.instagram.com/','m.instagram.com/','https://web.instagram.com/','web.instagram.com/','INSTAGRAM.com','/'];
                            $ig_clean_url = str_replace($arr_replace_ig, "", $data->instagram);
                        }
                        $org_type = NULL;
                        if (!empty($data->type_of_org[0])) {
                            $sql_org_type = DB::table('organization_types')->where('name', '=', $data->type_of_org[0])->first();
                            if (!empty($sql_org_type)) {
                                $org_type = $sql_org_type->id;
                            }
                        }
                        $purchasing_role = NULL;
                        if (!empty($data->company_representative->purchasing_role)) {
                            $sql_role_type = DB::table('company_role_purchasing_activities')->where('name', '=', $data->company_representative->purchasing_role)->first();
                            if (!empty($sql_role_type)) {
                                $purchasing_role = $sql_role_type->id;
                            }
                        }
                        $arr_buyers = [
                            'country' => $this->getCountryID($data->country),
                            'co_email' => Str::lower($data->company_email),
                            'state' => $data->province,
                            'city' => $data->add_city,
                            'zipcode' => $data->zipcode,
                            'region' => $data->region,
                            'street' => $data->add_st,
                            'country_code' => $this->getCountryCode($data->country),
                            'area_code' => NULL,
                            'phone_no' => $data->tel_off,
                            'website' => $data->website,
                            'year_established' => $data->year_established ? $data->year_established : NULL,
                            'facebook' => $fb_clean_url,
                            'instagram' => $ig_clean_url,
                            'linkedin' => $data->linkedin,
                            'twitter' => $twitter_clean_url,
                            'other_social' => $data->pinterest,
                            'organization_type_id' => $org_type,
                            'honorific' => $data->company_representative->salutation,
                            'fname' => $data->company_representative->first_name,
                            'lname' => $data->company_representative->last_name,
                            'mi' => NULL,
                            'designation' => $data->company_representative->designation,
                            'email' => Str::lower($data->company_email),
                            'company_role_id' => $purchasing_role,
                            'interested_meeting' => $data->prearranged_meeting == 'Yes' ? 1 : 0,
                            'need_interpreter' => $data->need_interpreter == 'Yes' ? 1 : 0
                        ];
                        $user->buyer()->updateOrCreate(
                            [
                                'co_email' => $data->company_email
                            ],$arr_buyers
                            
                        );
                        //NATURE BUSINESS
                        if (!empty($data->nature_of_business)) {
                            if (!empty($user->nature_business)) {
                                $user->nature_business()->delete();
                            }
                            $arr_nature_business = [];
                            foreach ($data->nature_of_business as $nb) {
                                $nature_business = DB::table('nature_businesses')->where('name', '=', $nb)->first();
                                if (!empty($nature_business)) {
                                    $arr_nature_business[] = [
                                        'nature_business_id' => $nature_business->id,
                                        'remarks' => $nature_business->name
                                    ];
                                }
                            }
                            $user->nature_business()->createMany($arr_nature_business);
                        }
                        //Categories & Sub-Categories
                        if (!empty($data->company_interest)) {
                            if (!empty($user->category_subcategory)) {
                                $user->category_subcategory()->delete();
                            }
                            $arr_categories = [];
                            foreach ($data->company_interest as $sub) {
                                $sub_category = SubCategory::where('name', '=', $sub)->first();
                                if (!empty($sub_category)) {
                                    $arr_categories[] = [
                                        'category_id' => $sub_category->category_id,
                                        'category_remarks' => $sub_category->category->name,
                                        'sub_category_id' => $sub_category->id,
                                        'sub_category_remarks' => $sub_category->name
                                    ];
                                }
                            }
                            $user->category_subcategory()->createMany($arr_categories);
                        }
                        //PARTICIPATION GOALS
                        if (!empty($data->participation_goals_code)) {
                            if (!empty($user->participation_goal)) {
                                $user->participation_goal()->delete();
                            }
                            $arr_participation_goal = [];
                            foreach ($data->participation_goals_code as $goal) {
                                $participation_goal = ParticipationGoal::where('item_code', '=', $goal)->first();
                                if (!empty($participation_goal)) {
                                    if ($participation_goal->item_code == 'R22') {
                                        $remarks = @ucwords($goal);
                                    } else {
                                        $remarks = $participation_goal->name;
                                    }
                                    $arr_participation_goal[] = [
                                        'participation_id' => $participation_goal->id,
                                        'remarks' => $remarks
                                    ];
                                }
                            }
                            $user->participation_goal()->createMany($arr_participation_goal);
                        }
                        //HOW DID YOU LEARN ABOUT THE EVENT
                        if (!empty($data->learn_event_code)) {
                            if (!empty($user->learn_about_event)) {
                                $user->learn_about_event()->delete();
                            }
                            $arr_learn_about_event = [];
                            foreach ($data->learn_event_code as $event) {
                                $about_event = AboutEvent::where('item_code', '=', $event)->first();
                                if (!empty($about_event)) {
                                    if ($about_event->id === 9) {
                                        $remarks = @ucwords($event);
                                    } else {
                                        $remarks = $about_event->name;
                                    }
                                    $arr_learn_about_event[] = [
                                        'learn_about_event_id' => $about_event->id,
                                        'remarks' => $remarks
                                    ];
                                }
                            }
                            $user->learn_about_event()->createMany($arr_learn_about_event);
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

    protected function getCountryID($str)
    {
        $country = DB::table('countries')->where('name', 'like', '%'.$str.'%')->first();
        if (!empty($country)) {
            return $country->id;
        } else {
            return 0;
        }
    }

    protected function getCountryCode($str)
    {
        $country = DB::table('countries')->where('name', 'like', '%'.$str.'%')->first();
        if (!empty($country)) {
            return $country->dial;
        } else {
            return 0;
        }
    }

    protected function getTotalRecords()
    {
        $url = env('SSX_API_URL').'/proj_buyers?limit=1&offset=0';
        $response = Http::withHeaders([
            'x-api-key' => env('SSX_API_KEY')
        ])->get($url);

        $result = $response->object();

        $total_records = 0;
        $offset = 5;

        if ($result->status == 'success') {
            if (!empty($result->paging)) {
                $total_records = $result->paging->total_records;

                $pager = DB::table('api_page')->where('export', '=', 'buyer')->where('status', 1)->latest()->first();
                if (!empty($pager)) {
                    if ($pager->total_records == $total_records) {
                        $curr_page = $pager->current_page+$offset;
                        DB::table('api_page')->insert(
                            ['export' => 'buyer', 'total_records' => $total_records, 'current_page' => $curr_page, 'status' => 1, 'created_at' => Carbon::now()]
                        );
                    } else {
                        DB::table('api_page')->insert(
                            ['export' => 'buyer', 'total_records' => $total_records, 'current_page' => 0, 'status' => 1, 'created_at' => Carbon::now()]
                        );
                    }
                } else {
                    DB::table('api_page')->insert(
                        ['export' => 'buyer', 'total_records' => $total_records, 'current_page' => 0, 'status' => 1, 'created_at' => Carbon::now()]
                    );
                }    
            }
        }
        return true;
    }
}
