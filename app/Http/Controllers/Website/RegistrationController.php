<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\BuyerEmailRegistrationSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Mail\ExhibitorEmailRegistrationValidation;
use App\Mail\ExhbitorRegistrationSuccess;
use App\Mail\BuyerEmailRegistrationValidation;
use App\Mail\SubmitRegistration;
use App\Models\Buyer\ExhibitorAttendance;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Exhibitor;
use App\Models\Buyer;
use App\Models\Certification;
use App\Models\SubCategory;
use App\Models\ParticipationGoal;
use App\Models\AboutEvent;
use App\Models\Buyer\BuyerAttendance;
use App\Models\NatureBusiness;
use App\Models\TargetBuyer;
use App\Models\Product;
use App\Models\Supplier\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Image;
use PDF;
use App\Helpers\QRTokenHelper;

class RegistrationController extends Controller
{


private function parseEmailList($value)
{
if (!$value) {
    return [];
}

// Convert comma-separated string into array
$emails = is_array($value) ? $value : explode(',', $value);

// Trim & filter
return array_values(array_filter(array_map('trim', $emails)));
}


    public function supplier_intro()
    {
        return view('website.registration.exhibitor.intro');
    }

    public function supplier()
    {
        return view('website.registration.exhibitor.index');
    }

    public function buyer_intro()
    {
        return view('website.registration.buyer.intro');
    }

    public function buyer()
    {
        return view('website.registration.buyer.index');
    }

    public function user_information($id)
    {

        $event = Event::latest()->first();
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            $user->exhibitor;
            $user->products;
            $user->exhibitor->factory_country;
            $user->exhibitor->main_country;
            $user->business_owner;
            $user->business_contact_person;
            $user->exhibitor->business_registration_type;
            $user->exhibitor->company_size;
            $user->exhibitor->annual_sales_volume;
            $user->exhibitor->organization_type;
            $user->nature_business;
            $user->target_buyer;
            $user->exhibitor->country_target_buyer_export_1;
            $user->exhibitor->country_target_buyer_export_2;
            $user->exhibitor->country_target_buyer_export_3;
            $user->exhibitor->country_exporting_to_1;
            $user->exhibitor->country_exporting_to_2;
            $user->exhibitor->country_exporting_to_3;
            $user->certification;
            $user->category_subcategory;
            $user->on_input_output;
            $user->on_production_process;
            $user->topic_rank;
            $user->exhibitor->banner_size;
            $user->exhibitor->reviewer;
            $user->exhibitor->approver;
            $user->exhibitor->disapprover;
            $user->exhibitor->onholder;
            $user->exhibitor->updater;
            $arr_categories = [];
            $arr_inout = [];
            $arr_process = [];
            $arr_rank = [];
            if ($user->status === 0) {
                $user['reg_link'] = route('registration.supplier.steps', [$user->reg_token]);
            } else {
                $user['reg_link'] = '';
            }
            if (!empty($user->category_subcategory)) {
                foreach ($user->category_subcategory as $key => $category) {
                    $arr_categories[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $arr_categories;
            }
            if (!empty($user->on_input_output)) {
                foreach ($user->on_input_output as $inout) {
                    $arr_inout[] = [
                        'id' => $inout->id,
                        'name' => $inout->product_char_inputoutput->name
                    ];
                }
                $user['inout'] = $arr_inout;
            }
            if (!empty($user->on_production_process)) {
                foreach ($user->on_production_process as $process) {
                    $arr_process[] = [
                        'id' => $process->id,
                        'name' => $process->product_char_prod_process->name
                    ];
                }
                $user['process'] = $arr_process;
            }
            if (!empty($user->topic_rank)) {
                foreach ($user->topic_rank as $rank) {
                    $arr_rank[] = [
                        'id' => $rank->topic_id,
                        'name' => $rank->focus_ranking->name,
                        'rank' => $rank->rank
                    ];
                }
                $user['rank'] = $arr_rank;
            }
            if (!empty($user->masthead)) {
                $arr_masthead = pathinfo('/storage/exhibitors/mastheads/'.$user->masthead);
                $user['masthead'] = $arr_masthead;
            }
            if (!empty($user->logo)) {
                $arr_logo = pathinfo('/storage/exhibitors/logos/'.$user->logo);
                $user['logo'] = $arr_logo;
            }
            if (!empty($user->document->dti_sec)) {
                $arr_doc1 = pathinfo($user->document->dti_sec);
                $user['doc1'] = $arr_doc1;
                $user['doc1_url'] = Storage::url($user->document->dti_sec);
                $user['doc1_filesize'] = Storage::size($user->document->dti_sec);
            }
            if (!empty($user->document->bir)) {
                $arr_doc2 = pathinfo($user->document->bir);
                $user['doc2'] = $arr_doc2;
                $user['doc2_url'] = Storage::url($user->document->bir);
                $user['doc2_filesize'] = Storage::size($user->document->bir);
            }
            if (!empty($user->document->lto)) {
                $arr_doc3 = pathinfo($user->document->lto);
                $user['doc3'] = $arr_doc3;
                $user['doc3_url'] = Storage::url($user->document->lto);
                $user['doc3_filesize'] = Storage::size($user->document->lto);
            }
            if (!empty($user->document->cpr)) {
                $arr_doc4 = pathinfo($user->document->cpr);
                $user['doc4'] = $arr_doc4;
                $user['doc4_url'] = Storage::url($user->document->cpr);
                $user['doc4_filesize'] = Storage::size($user->document->cpr);
            }
            if (!empty($user->document->other_food_certificate)) {
                $arr_doc5 = pathinfo($user->document->other_food_certificate);
                $user['doc5'] = $arr_doc5;
                $user['doc5_url'] = Storage::url($user->document->other_food_certificate);
                $user['doc5_filesize'] = Storage::size($user->document->other_food_certificate);
            }
            if (!empty($user->document->institutional_catalog)) {
                $arr_doc6 = pathinfo($user->document->institutional_catalog);
                $user['doc6'] = $arr_doc6;
                $user['doc6_url'] = Storage::url($user->document->institutional_catalog);
                $user['doc6_filesize'] = Storage::size($user->document->institutional_catalog);
            }
        } else {
        // For buyers, get the buyer record for this event only
        $buyer = $user->buyer()->where('fair_code', $event->fair_code)->first();

        if ($buyer) {
            $user['buyer'] = $buyer;

            // Access related attributes safely
            $buyer->b_country;
            $buyer->job_function;
            $buyer->organization_type;
            $user['nature_business'] = $user->nature_business()
                                    ->where('fair_code', $event->fair_code)
                                    ->get();
            $user['category_subcategory'] = $user->category_subcategory()
                                        ->where('fair_code', $event->fair_code)
                                        ->get();

            $user['participation_goal'] = $user->participation_goal()
                                        ->where('fair_code', $event->fair_code)
                                        ->get();
            $user['learn_about_event'] = $user->learn_about_event()
                                      ->where('fair_code', $event->fair_code)
                                      ->get();
            $buyer->reviewer;
            $buyer->approver;
            $buyer->disapprover;
            $buyer->onholder;
            $buyer->last_update;

            $arr_categories = [];
            if (!empty($user->category_subcategory)) {
                foreach ($user->category_subcategory as $key => $category) {
                    $arr_categories[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $arr_categories;
            }
        } else {
            // No buyer exists for this event yet
            $user['buyer'] = null;
        }
    }

        return response()->json($user, 200);
    }

    public function product_information($id)
    {
        $product = Product::withCount('product_images')->find($id);
        $product->product_images_count;
        $product->product_images;
        $product->product_profiles;
        $product->product_certifications;

        return response()->json($product, 200);
    }

    public function supplier_email_validation(Request $request)
    {
        $user = new User;
        $user->name = Str::upper($request->input('company_name'));
        // $user->email = Str::of($request->input('company_email'))->lower();
        $user->email = strtolower($request->input('company_email'));

        $user->password = NULL;
        $user->status = 0;
        $user->user_group = 2;
        $user->reg_token = sha1(time());
        $user->save();

        $exhibitor = new Exhibitor;
        $exhibitor->co_name = Str::upper($request->input('company_name'));
        // $exhibitor->co_email = Str::of($request->input('company_email'))->lower();
        $exhibitor->co_email = strtolower($request->input('company_email'));

        $exhibitor->slug = Str::of($request->input('company_name'))->slug('-');
        $user->exhibitor()->save($exhibitor);

        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($request->input('company_email')))->send(new ExhibitorEmailRegistrationValidation($user->id));
        } else {
            Mail::to('kgtecson.citem@gmail.com')->send(new ExhibitorEmailRegistrationValidation($user->id));
        }

        // if (env('SSX_API_SYNC')) {
        //     $this->citemAPICreate($user->id);
        // }

        return response()->json(true, 200);
    }

 
public function buyer_email_validation(Request $request)
{
    // $email   = Str::of($request->input('ref_email'))->lower();
    $email = strtolower($request->input('ref_email'));
    $company = Str::upper($request->input('company_name'));
    $event   = Event::latest()->first();

    // Check if user exists
    $user = User::where('email', $email)->first();
    $newUser = false;

    if (!$user) {
        // Create new user
        $user = User::create([
            'email'      => $email,
            'name'       => $company,
            'password'   => null,
            'status'     => 0,
            'user_group' => 3,
            'reg_token'  => sha1(time()),
        ]);
        $newUser = true;
        $subject = 'SSX Email Purchaser/Buyer Registration - ' . $event->event_name;
    } else {
        // Ensure token exists
        if (!$user->reg_token) {
            $user->reg_token = sha1(time());
            $user->save();
        }
    }

    // Create BuyerAttendance if not existing
    $attendance = BuyerAttendance::firstOrCreate(
        [
            'user_id'   => $user->id,
            'fair_code' => $event->fair_code,
        ],
        
        [
             'qr_token' => QRTokenHelper::generateToken(
            QRTokenHelper::TYPE_BUYER
        ),
            'status'                        => 0,
            'registration_agreement_id'     => 1,
            'registration_agreement_status' => 0,
            'privacy_policy_id'             => 3,
            'privacy_policy_status'         => 0,
            'information_sharing_id'        => 4,
            'information_sharing_status'    => 0,
        ]
    );

    // Determine email subject for existing users
    if (!$newUser) {
        $subject = $attendance->wasRecentlyCreated
            ? 'SSX Register for Upcoming - ' . $event->event_name
            : 'SSX Email Continuation Registration - ' . $event->event_name;
    }
 
    $company_name = $user->name;

    // Create Buyer only if not existing for this fair_code
    $existingBuyer = $user->buyer()->where('fair_code', $event->fair_code)->first();
    if (!$existingBuyer) {
        $buyer = new Buyer;
        $buyer->fair_code = $event->fair_code;
        $buyer->co_name   = $company_name;
        $buyer->email     = $email;
        $buyer->slug      = Str::slug($company_name);
        $user->buyer()->save($buyer);
    }

    // Send email
    $recipient = env('APP_ENV') != 'local' ? $email : 'kgtecson.citem@gmail.com';

    try {
        Mail::to($recipient)->send(new BuyerEmailRegistrationValidation($user->id, $subject, $event->fair_code));
    } catch (\Exception $e) {
        Log::error('Mail error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }

    // API sync only for new users
    if ($newUser && env('SSX_API_SYNC')) {
        $this->citemAPICreate($user->id);
    }

    return response()->json(true, 200);
}


public function supplier_registration($token)
    {
        if ($token) {
            $exhibitor = User::where('reg_token', '=', $token)->where('status', 0)->firstOrFail();
            return view('website.registration.exhibitor.registration', ['id' => $exhibitor->id]);
        } else {
            abort(404);
        }
}

    // public function buyer_registration($token)
    // {
    //     if ($token) {
    //         $buyer = User::where('reg_token', '=', $token)->where('status', 0)->firstOrFail();
    //         return view('website.registration.buyer.registration', ['id' => $buyer->id]);
    //     } else {
    //         abort(404);
    //     }
    // }

public function buyer_registration($token)
{
    if (!$token) {
        abort(404);
    }

    // Find user by token
    $user = User::where('reg_token', $token)->firstOrFail();

    $event = Event::latest()->first();

    // Check BuyerAttendance for this user & event
    $attendance = BuyerAttendance::where('user_id', $user->id)
                                 ->where('fair_code', $event->fair_code)
                                 ->first();

    if (!$attendance || $attendance->status !== 0) {
    abort(404, 'You cannot access this registration.');
}


    // Continue to registration page
    return view('website.registration.buyer.registration', ['id' => $user->id]);
}





    public function supplier_store(Request $request)
    {
        $user = User::where('reg_token', '=', $request->input('token'))->where('id', $request->input('user_id'))->firstOrFail();

        if ($request->input('step') == 1) {
            $step1_decode = json_decode($request->input('step1_data'), true);

            $destinationPath = storage_path('app/public/exhibitors/');
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                if ($logo) {
                    $filename_logo = md5(time()).'.'.$logo->clientExtension();
                    $logo_canvas = Image::canvas(156, 156);
                    $resize_logo = Image::make($logo);
                    $resize_logo->resize(155, 155, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $logo_canvas->insert($resize_logo, 'center');
                    $logo_canvas->save($destinationPath.'/logos/'.$filename_logo, 70);
                    $user->logo = $filename_logo;
                }
            }
            if ($request->hasFile('masthead')) {
                $masthead = $request->file('masthead');
                if ($masthead) {
                    $filename_masthead = md5(time()).'.'.$masthead->clientExtension();
                    $resize_masthead = Image::make($masthead);
                    $resize_masthead->fit(1920, 400, function ($constraint) {
                        $constraint->upsize();
                    });
                    $resize_masthead->save($destinationPath.'/mastheads/'.$filename_masthead, 70);
                    $resize_masthead->fit(290, 160, function ($constraint) {
                        $constraint->upsize();
                    });
                    $resize_masthead->save($destinationPath.'/thumbs/'.$filename_masthead, 70);
                    $user->masthead = $filename_masthead;
                }
            }
            $user->save();

            $user->exhibitor()->update([
                'directory_name' => Str::title($step1_decode['directory_name']),
                'co_details' => $step1_decode['co_details'],
                'mission_statement' => $step1_decode['mission'],
                'env_conservation' => $step1_decode['env_conservation'],
                'phone_country_code' => $step1_decode['country_code'],
                'phone_area_code' => $step1_decode['area_code'],
                'phone_no' => $step1_decode['phone_no'],
                'mobile_country_code' => $step1_decode['country_code_mobile'],
                'mobile_no' => $step1_decode['mobile_no'],
                'website' => $step1_decode['website'],
                'facebook' => $step1_decode['facebook'],
                'twitter' => $step1_decode['twitter'],
                'instagram' => $step1_decode['instagram'],
                'linkedin' => $step1_decode['linkedin'],
                'other_social' => $step1_decode['other_social'],
                'fa_country' => $step1_decode['fa_country'],
                'fa_state' => $step1_decode['fa_state'],
                'fa_city' => $step1_decode['fa_city'],
                'fa_zipcode' => $step1_decode['fa_zipcode'],
                'fa_region' => $step1_decode['fa_region'],
                'fa_street' => $step1_decode['fa_street'],
                'fa_same_as_moa' => $step1_decode['same_as_moa'],
                'moa_country' => $step1_decode['moa_country'],
                'moa_state' => $step1_decode['moa_state'],
                'moa_city' => $step1_decode['moa_city'],
                'moa_zipcode' => $step1_decode['moa_zipcode'],
                'moa_region' => $step1_decode['moa_region'],
                'moa_street' => $step1_decode['moa_street']
            ]);
            if (env('SSX_API_SYNC')) {
                $this->citemAPIUpdateExhibitor($user->id);
            }
        } elseif ($request->input('step') == 'add_product') {
            $prod_info = json_decode($request->input('prod_info'), true);

            $product = $user->products()->updateOrCreate(
                [
                    'id' => $request->input('product_id')
                ],
                [
                    'name' => $prod_info['prod_name'],
                    'slug' => Str::of($prod_info['prod_name'])->slug('-'),
                    'description' => $prod_info['prod_details'],
                    'store_url' => $prod_info['store_url'],
                    'status' => $user->status === 1 ? 1 : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );

            $destinationPath = storage_path('app/public/exhibitors/products');
            $arr_product_images = [];
            if (!empty($prod_info['prod_images_for_upload'])) {
                foreach ($prod_info['prod_images_for_upload'] as $key => $photo) {
                    $filename = md5(time()).'_'.uniqid().'.'.$photo['ext'];
                    $productImage = Image::make($photo['urlResized']);
                    $size = $productImage->filesize();

                    $productImage->fit(360, 200, function ($constraint1) {
                        $constraint1->upsize();
                    });
                    $productImage->save($destinationPath.'/thumbs/'.$filename);

                    $productImage->fit(800, 620, function ($constraint2) {
                        $constraint2->upsize();
                    });
                    
                    $productImage->save($destinationPath.'/'.$filename);

                    $arr_product_images[] = [
                        'image' => $filename,
                        'img_size' => $size,
                        'img_type' => 'image/'.$photo['ext'],
                        'img_ext' => $photo['ext']
                    ];
                }
                $product->product_images()->createMany($arr_product_images);
            }
            //Categories & Sub-Categories
            if (!empty($product->product_profiles)) {
                $product->product_profiles()->delete();
            }
            $arr_categories = [];
            foreach ($prod_info['prod_profiles'] as $sub) {
                $sub_category = SubCategory::find($sub);
                if (!empty($sub_category)) {
                    $arr_categories[] = [
                        'category_id' => $sub_category->category_id,
                        'category_remarks' => $sub_category->category->name,
                        'sub_category_id' => $sub_category->id,
                        'sub_category_remarks' => $sub_category->name
                    ];
                }
            }
            $product->product_profiles()->createMany($arr_categories);

            //CERTIFICATIONS
            if (!empty($product->product_certifications)) {
                $product->product_certifications()->delete();
            }
            $arr_certifications = [];
            foreach ($prod_info['prod_certs'] as $cert) {
                $certification = Certification::find($cert);
                if (!empty($certification)) {
                    if ($certification->id === 14) {
                        $remarks = Str::title($prod_info['certs_others']);
                    } else {
                        $remarks = $certification->name;
                    }
                    $arr_certifications[] = [
                        'certification_id' => $certification->id,
                        'remarks' => $remarks
                    ];
                }
            }
            $product->product_certifications()->createMany($arr_certifications);
        } elseif ($request->input('step') == 'save_product') {
            $user->products()->update([
                'status' => 1
            ]);
        } elseif ($request->input('step') == 2) {
            $step2_decode = json_decode($request->input('step2_data'), true);
            $user->business_owner()->updateOrCreate(
                [
                    'uid' => $user->id
                ],
                [
                    'fname' => Str::title($step2_decode['fname']),
                    'lname' => Str::title($step2_decode['lname']),
                    'mi' => Str::upper($step2_decode['mi']),
                    'designation' => $step2_decode['designation'],
                    'email' => str::lower($step2_decode['email']),
                    'country_code' => $step2_decode['country_code_mobile_bo'],
                    'mobile_no' => $step2_decode['mobile_no_bo']
                ]
            );
            $user->business_contact_person()->updateOrCreate(
                [
                    'uid' => $user->id
                ],
                [
                    'fname' => Str::title($step2_decode['bcp_fname']),
                    'lname' => Str::title($step2_decode['bcp_lname']),
                    'mi' => Str::upper($step2_decode['bcp_mi']),
                    'designation' => $step2_decode['bcp_designation'],
                    'email' => str::lower($step2_decode['bcp_email']),
                    'country_code' => $step2_decode['bcp_country_code'],
                    'mobile_no' => $step2_decode['bcp_mobile_no'],
                    'same_as_bo' => $step2_decode['same_as_bo'] ? 1 : 0
                ]
            );
            if (env('SSX_API_SYNC')) {
                $this->citemAPIUpdateExhibitor($user->id);
            }
        } elseif ($request->input('step') == 3) {
            $step3_decode = json_decode($request->input('step3_data'), true);
            $user->exhibitor()->update([
                'business_type_id' => $step3_decode['business_type'],
                'company_size_id' => $step3_decode['company_size'],
                'annual_sales_volume_id' => $step3_decode['annual_sales_volume'],
                'direct_workers' => $step3_decode['direct'],
                'indirect_workers' => $step3_decode['indirect'],
                'target_country_export_1' => $step3_decode['target_country_1'],
                'target_country_export_2' => $step3_decode['target_country_2'],
                'target_country_export_3' => $step3_decode['target_country_3'],
                'organization_type_id' => $step3_decode['organization_type'],
                'industry_rep' => $step3_decode['industry_representation'],
                'ir_country_exporting_1' => $step3_decode['exporting_country_1'] ? $step3_decode['exporting_country_1'] : NULL,
                'ir_country_exporting_2' => $step3_decode['exporting_country_2'] ? $step3_decode['exporting_country_2'] : NULL,
                'ir_country_exporting_3' => $step3_decode['exporting_country_3'] ? $step3_decode['exporting_country_3'] : NULL,
                'product_promoted' => $step3_decode['product_promoted']
            ]);
            //NATURE BUSINESS
            if (!empty($user->nature_business)) {
                $user->nature_business()->delete();
            }
            $arr_nature_business = [];
            foreach ($step3_decode['nature_business'] as $nb) {
                $nature_business = NatureBusiness::find($nb);
                if (!empty($nature_business)) {
                    $arr_nature_business[] = [
                        'nature_business_id' => $nature_business->id,
                        'remarks' => $nature_business->name
                    ];
                }
            }
            $user->nature_business()->createMany($arr_nature_business);
            //TARGET BUYERS
            if (!empty($user->target_buyer)) {
                $user->target_buyer()->delete();
            }
            $arr_target_buyers = [];
            foreach ($step3_decode['target_buyer'] as $target) {
                $target_buyer = TargetBuyer::find($target);
                if (!empty($target_buyer)) {
                    if ($target_buyer->id === 6) {
                        $remarks = Str::title($step3_decode['target_buyer_others']);
                    } else {
                        $remarks = $target_buyer->name;
                    }
                    $arr_target_buyers[] = [
                        'target_buyer_id' => $target_buyer->id,
                        'remarks' => $remarks
                    ];
                }
            }
            $user->target_buyer()->createMany($arr_target_buyers);
            //CERTIFICATIONS
            if (!empty($user->certification)) {
                $user->certification()->delete();
            }
            $arr_certifications = [];
            foreach ($step3_decode['certification'] as $cert) {
                $certification = Certification::find($cert);
                if (!empty($certification)) {
                    if ($certification->id === 14) {
                        $remarks = Str::title($step3_decode['certification_others']);
                    } else {
                        $remarks = $certification->name;
                    }
                    $arr_certifications[] = [
                        'certification_id' => $certification->id,
                        'remarks' => $remarks
                    ];
                }
            }
            $user->certification()->createMany($arr_certifications);
            //Categories & Sub-Categories
            if (!empty($user->category_subcategory)) {
                $user->category_subcategory()->delete();
            }
            $arr_categories = [];
            foreach ($step3_decode['category'] as $sub) {
                $sub_category = SubCategory::find($sub);
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
            //On Input / Output
            if (!empty($user->on_input_output)) {
                $user->on_input_output()->delete();
            }
            $arr_input_ouput = [];
            foreach ($step3_decode['input_ouput'] as $input_output) {
                $arr_input_ouput[] = [
                    'input_output_id' => $input_output
                ];
            }
            $user->on_input_output()->createMany($arr_input_ouput);
            //On Production Process
            if (!empty($user->on_production_process)) {
                $user->on_production_process()->delete();
            }
            $arr_production_process = [];
            foreach ($step3_decode['production_process'] as $pprocess) {
                if ($pprocess === 3) {
                    $pp_remarks = Str::title($step3_decode['production_process_others']);
                } else {
                    $pp_remarks = NULL;
                }
                $arr_production_process[] = [
                    'production_process_id' => $pprocess,
                    'other_certification' => $pp_remarks
                ];
            }
            $user->on_production_process()->createMany($arr_production_process);
            //TOPIC RANGKING
            if (!empty($user->topic_rank)) {
                $user->topic_rank()->delete();
            }
            $arr_topic_rank = [];
            foreach ($step3_decode['ranking'] as $rank_key => $rank) {
                if ($rank_key >= 1) {
                    $arr_topic_rank[] = [
                        'topic_id' => $rank_key,
                        'rank' => $rank
                    ];
                }
            }
            $user->topic_rank()->createMany($arr_topic_rank);

            if (env('SSX_API_SYNC')) {
                $this->citemAPIUpdateExhibitor($user->id);
            }
        } elseif ($request->input('step') == 4) {
            $step4_decode = json_decode($request->input('step4_data'), true);
            $user->exhibitor()->update([
                'banner_size_id' => $step4_decode['banner_size']
            ]);
            if (env('SSX_API_SYNC')) {
                $this->citemAPIUpdateExhibitor($user->id);
            }
        } else {
            if ($request->hasFile('doc1')) {
                $doc1 = $request->file('doc1')->store('public/documents', 'local');
            } else {
                $doc1 = $user->document ?? optional($user->document)->dti_sec;
            }
            if ($request->hasFile('doc2')) {
                $doc2 = $request->file('doc2')->store('public/documents', 'local');
            } else {
                $doc2 = $user->document ?? optional($user->document)->bir;
            }
            if ($request->hasFile('doc3')) {
                $doc3 = $request->file('doc3')->store('public/documents', 'local');
            } else {
                $doc3 = $user->document ?? optional($user->document)->lto;
            }
            if ($request->hasFile('doc4')) {
                $doc4 = $request->file('doc4')->store('public/documents', 'local');
            } else {
                $doc4 = $user->document ?? optional($user->document)->cpr;
            }
            if ($request->hasFile('doc5')) {
                $doc5 = $request->file('doc5')->store('public/documents', 'local');
            } else {
                $doc5 = $user->document ?? optional($user->document)->other_food_certificate;
            }
            if ($request->hasFile('doc6')) {
                $doc6 = $request->file('doc6')->store('public/documents', 'local');
            } else {
                $doc6 = $user->document ?? optional($user->document)->institutional_catalog;
            }
            $user->status = 1;
            $user->save();
            $user->document()->updateOrCreate(
                [
                    'uid' => $user->id
                ],
                [
                    'dti_sec' => $doc1,
                    'bir' => $doc2,
                    'lto' => $doc3,
                    'cpr' => $doc4,
                    'other_food_certificate' => $doc5,
                    'institutional_catalog' => $doc6
                ]
            );

            $this->generate_pdf($user->id);
            
            if (env('APP_ENV') != 'local') {
                Mail::to($user->exhibitor->co_email)->send(new ExhbitorRegistrationSuccess($user->id));
            } else {
                Mail::to('kgtecson.citem@gmail.com')->send(new ExhbitorRegistrationSuccess($user->id));
            }
            // if (env('SSX_API_SYNC')) {
            //     $this->citemAPIUpdateExhibitor($user->id);
            //     $this->citemAPIValidateStatus($user->email, 'pending', $user->user_group);
            // }
        } 
        return response()->json(true, 200);
    }


public function buyer_store(Request $request)
{
// Fetch user safely using token + user_id
$user = User::where('reg_token', $request->input('token'))
->where('id', $request->input('user_id'))
->firstOrFail();


$fair_code = $request->input('fair_code');
$event = Event::where('fair_code', $fair_code)->first();

$step = $request->input('step');

if ($step == 1) {
    $step1_decode = json_decode($request->input('step1_data'), true);

    // Validation
    $validator = Validator::make($step1_decode, [
        'country' => 'required|max:15',
        'co_email' => 'required|email|',
        'state' => 'nullable|string|max:95',
        'city' => 'nullable|string|max:95',
        'zipcode' => 'nullable|string|max:9',//backend 10
        'region' => 'nullable|string|max:95',
        'street' => 'nullable|string|max:95',
        'country_code' => 'nullable|string|max:10',//backend 10
        'area_code' => 'nullable|string|max:10',//backend 10
        'phone_no' => 'nullable|string|max:20',//backend 100
        'website' => 'nullable|max:140',//backend 150
        'year_established' => 'nullable|integer|min:7|max:' . date('Y'),//backend 10
        'facebook' => 'nullable|string|max:195',
        'instagram' => 'nullable|string|max:195',
        'linkedin' => 'nullable|string|max:195',
        'other_social' => 'nullable|string|max:195',
        'organization_type' => 'nullable|integer|exists:organization_types,id',
        'annual_purchase_existing_supplier' => 'nullable|integer|exists:annual_purchase_existing_supplier,id',
        'company_annual_sale' => 'nullable|integer|exists:company_annual_sales,id',
        'ph_supplier_name' => 'nullable|string|max:400',
        'honorific' => 'nullable|string|max:10',//backend 10
        'fname' => 'required|string|max:95',
        'lname' => 'required|string|max:95',
        'mi' => 'nullable|string|max:4',
        'designation' => 'required|string|max:95',
        'email' => 'required|email|max:195',
        'role' => 'required|integer|max:15',
        'nature_business' => 'array',
        'nature_business.*' => 'integer|exists:nature_businesses,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $buyer = $user->buyerForFair($fair_code) ?? $user->buyer()->create(['fair_code' => $fair_code]);

    $buyer->update([
        'country' => $step1_decode['country'],
        'co_email' => Str::lower($step1_decode['co_email']),
        'state' => $step1_decode['state'],
        'city' => $step1_decode['city'],
        'zipcode' => $step1_decode['zipcode'],
        'region' => $step1_decode['region'],
        'street' => $step1_decode['street'],
        'country_code' => $step1_decode['country_code'],
        'area_code' => $step1_decode['area_code'],
        'phone_no' => $step1_decode['phone_no'],
        'website' => $step1_decode['website'],
        'year_established' => $step1_decode['year_established'],
        'facebook' => $step1_decode['facebook'],
        'instagram' => $step1_decode['instagram'],
        'linkedin' => $step1_decode['linkedin'],
        'other_social' => $step1_decode['other_social'],
        'organization_type_id' => $step1_decode['organization_type'],
        'company_annual_sale_id' => $step1_decode['company_annual_sale'],
        'annual_purchase_from_existing_supplier_id' => $step1_decode['annual_purchase_existing_supplier'],
        'has_ph_business_supplier' => $step1_decode['has_ph_business_supplier'],
        'ph_supplier_name' => $step1_decode['ph_supplier_name'],
        'honorific' => $step1_decode['honorific'],
        'fname' => Str::title($step1_decode['fname']),
        'lname' => Str::title($step1_decode['lname']),
        'mi' => Str::upper($step1_decode['mi']),
        'designation' => Str::title($step1_decode['designation']),
        'email' => Str::lower($step1_decode['email']),
        'company_role_id' => $step1_decode['role']
    ]);
$buyer->last_update_by = $user->id;
$buyer->save();
    // Nature Business
    $user->nature_business()->where('fair_code', $fair_code)->delete();
    $arr_nature_business = [];
    foreach ($step1_decode['nature_business'] ?? [] as $nb) {
        $nature_business = NatureBusiness::find($nb);
        if ($nature_business) {
             $remarks = ($nature_business->id === 16)
                ? Str::title($step1_decode['nature_business_other'])
                : $nature_business->name;

            $arr_nature_business[] = [
                'nature_business_id' => $nature_business->id,
                'remarks' =>    $remarks,
                'fair_code' => $fair_code
            ];
        }
    }
    $user->nature_business()->createMany($arr_nature_business);

    
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateBuyer($user->id);
    // }
} elseif ($step == 2) {
    $step2_decode = json_decode($request->input('step2_data'), true);

    $validator = Validator::make($step2_decode, [
        'category' => 'required|array',
        'category.*' => 'integer|exists:sub_categories,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user->category_subcategory()->where('fair_code', $fair_code)->delete();
    $arr_categories = [];
    foreach ($step2_decode['category'] as $sub) {
        $sub_category = SubCategory::find($sub);
        if ($sub_category) {
            $arr_categories[] = [
                'category_id' => $sub_category->category_id,
                'category_remarks' => $sub_category->category->name,
                'sub_category_id' => $sub_category->id,
                'sub_category_remarks' => $sub_category->name,
                'fair_code' => $fair_code
            ];
        }
    }
    $user->category_subcategory()->createMany($arr_categories);

    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateBuyer($user->id);
    // }
} elseif ($step == 3) {
    $step3_decode = json_decode($request->input('step3_data'), true);

    $validator = Validator::make($step3_decode, [
        'interest' => 'required',
        'need_interpreter' => 'nullable',
        'participation_goal' => 'array',
        'participation_goal.*' => 'integer|exists:participation_goals,id',
        'participation_goal_other' => 'nullable|string|max:200',
        'about_event' => 'array',
        'about_event.*' => 'integer|exists:learn_about_event,id',
        'about_event_other' => 'nullable|string|max:200',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $buyer = $user->buyerForFair($fair_code);
    $buyer->update([
        'interested_meeting' => $step3_decode['interest'],
        'need_interpreter' => ($step3_decode['interest'] == 1) ? $step3_decode['need_interpreter'] : null
    ]);

    // Participation Goals
    $user->participation_goal()->where('fair_code', $fair_code)->delete();
    $arr_participation_goal = [];
    foreach ($step3_decode['participation_goal'] ?? [] as $goal) {
        $participation_goal = ParticipationGoal::find($goal);
        if ($participation_goal) {
            $remarks = ($participation_goal->id === 11)
                ? Str::title($step3_decode['participation_goal_other'])
                : $participation_goal->name;

            $arr_participation_goal[] = [
                'participation_id' => $participation_goal->id,
                'remarks' => $remarks,
                'fair_code' => $fair_code
            ];
        }
    }
    $user->participation_goal()->createMany($arr_participation_goal);

    // Learn About Event
    $user->learn_about_event()->where('fair_code', $fair_code)->delete();
    $arr_learn_about_event = [];
    foreach ($step3_decode['about_event'] ?? [] as $event_id) {
        $about_event = AboutEvent::find($event_id);
        if ($about_event) {
            $remarks = ($about_event->id === 9)
                ? Str::title($step3_decode['about_event_other'])
                : $about_event->name;

            $arr_learn_about_event[] = [
                'learn_about_event_id' => $about_event->id,
                'remarks' => $remarks,
                'fair_code' => $fair_code
            ];
        }
    }
    $user->learn_about_event()->createMany($arr_learn_about_event);

    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateBuyer($user->id);
    // }
} else {
    // Step 4 / Agreements
    $user->status = 2;
    $user->save();

    $user->buyerAttendances()->updateOrCreate(
        ['fair_code' => $fair_code],
        ['status' => 2]
    );

    $data = [];

    if ($request->filled('privacy_policy_id')) {
        $data['privacy_policy_id'] = $request->input('privacy_policy_id');
        $data['privacy_policy_status'] = 1;
        $data['privacy_policy_agreed_at'] = now();
    }

    if ($request->filled('information_sharing_id')) {
        $data['information_sharing_id'] = $request->input('information_sharing_id');
        $data['information_sharing_status'] = 1;
        $data['information_sharing_agreed_at'] = now();
    }

    if (!empty($data)) {
        BuyerAttendance::updateOrCreate(
            ['user_id' => $user->id, 'fair_code' => $fair_code],
            $data
        );
    }
    $buyer = $user->buyerForFair($fair_code);

      if (env('APP_ENV') != 'local') {
                Mail::to($buyer->co_email)->send(new BuyerEmailRegistrationSuccess($user->id, $fair_code));
            } else {
                Mail::to('kgtecson.citem@gmail.com')->send(new BuyerEmailRegistrationSuccess($user->id, $fair_code));
            }

      $BCC_Officer_Purchasers =  env('APP_ENV') != 'local' ? $this->parseEmailList(env('BCC_Officer_Purchasers')) : 'kgtecson.citem@gmail.com';

   Mail::to($BCC_Officer_Purchasers)->send(new SubmitRegistration($user, null , $event));
            // if (env('SSX_API_SYNC')) {
            //     $this->citemAPIUpdateExhibitor($user->id);
            //     $this->citemAPIValidateStatus($user->email, 'pending', $user->user_group);
            // }
}
return response()->json(true, 200);

}

    
    public function supplier_registration_thankyou($token)
    {
        $exhibitor = User::where('reg_token', '=', $token)->where('status', 2)->firstOrFail();
        return view('website.registration.exhibitor.thankyou', ['id' => $exhibitor->id]);
    }

    public function supplier_receive_updates(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->exhibitor->update([
            'received_latest_updates' => $request->input('agree') ? $request->input('agree') : 0
        ]);
        if (env('SSX_API_SYNC')) {
            $this->citemAPIUpdateExhibitor($user->id);
        }
        return redirect()->route('home');
    }

    // public function buyer_registration_thankyou($token)
    // {
    //     $buyer = User::where('reg_token', '=', $token)->where('status', 2)->firstOrFail();
    //     return view('website.registration.buyer.thankyou', ['id' => $buyer->id]);
    // }

   public function buyer_registration_thankyou($token, Request $request)
{
    $fair_code = $request->fair_code;

    if (!$fair_code) {
        return abort(404, 'Fair code is required.');
    }

    // Fetch user by token
    $buyer = User::where('reg_token', $token)->firstOrFail();

    // Fetch buyer attendance for this fair
    $buyerAttendance = BuyerAttendance::where('user_id', $buyer->id)
        ->where('fair_code', $fair_code)
        ->first();

    // Only allow if attendance exists and status = 2
    if (!$buyerAttendance || $buyerAttendance->status != 2) {
        return abort(404, 'Registration not yet completed.');
    }

    // Fetch event
    $event = Event::where('fair_code', $fair_code)->first();
    if (!$event) {
        return abort(404, 'Event not found.');
    }

    return view('website.registration.buyer.thankyou', [
        'id' => $buyer->id,
        'event_name' => $event->event_name
    ]);
}


    private function generate_pdf($id)
    {
        $user = User::find($id);
        $path = storage_path('app/public/exhibitor_summary/');
        $filename = $user->exhibitor->slug.'_'.$user->id.'.pdf';

        if (!empty($user->nature_business)) {
            $arr_nature_business = [];
            foreach ($user->nature_business as $nature) {
                array_push($arr_nature_business, $nature->remarks);
            }
            $nature_exp = implode(", ", $arr_nature_business);
        }

        if (!empty($user->target_buyer)) {
            $arr_target_buyers = [];
            foreach ($user->target_buyer as $target) {
                array_push($arr_target_buyers, $target->remarks);
            }
            $target_exp = implode(", ", $arr_target_buyers);
        }

        if (!empty($user->exhibitor->target_country_export_1)) {
            $arr_target_countries = [$user->exhibitor->country_target_buyer_export_1->name, $user->exhibitor->country_target_buyer_export_2->name, $user->exhibitor->country_target_buyer_export_3->name];
            $export_target_countries = implode(", ", $arr_target_countries);
        }

        if (!empty($user->certification)) {
            $arr_certifications = [];
            foreach ($user->certification as $cert) {
                array_push($arr_certifications, $cert->remarks);
            }
            $certifications_exp = implode(", ", $arr_certifications);
        }

        if ($user->exhibitor->industry_rep === 1) {
            $arr_exporting = [$user->exhibitor->country_exporting_to_1->name, $user->exhibitor->country_exporting_to_2->name, $user->exhibitor->country_exporting_to_3->name];
            $exporting_exp = implode(", ", $arr_exporting);
        } else {
            $exporting_exp = '';
        }

        if (!empty($user->category_subcategory)) {
            $arr_categories = [];
            $arr_subcategories = [];
            foreach ($user->category_subcategory as $category) {
                array_push($arr_categories, $category->category_remarks);
                array_push($arr_subcategories, ucwords($category->sub_category_remarks));
            }
            $category_exp = implode("|", array_unique($arr_categories));
            $subcategory_exp = implode(", ", $arr_subcategories);
        }

        if (!empty($user->on_input_output)) {
            $arr_char_inputoutput = [];
            foreach ($user->on_input_output as $inout) {
                array_push($arr_char_inputoutput, $inout->product_char_inputoutput->name);
            }
        }

        if (!empty($user->on_production_process)) {
            $arr_char_prod_process = [];
            foreach ($user->on_production_process as $prod_process) {
                array_push($arr_char_prod_process, $prod_process->product_char_prod_process->name);
            }
        }
        
        if (!empty($user->topic_rank)) {
            $arr_focus_ranking = [];
            foreach ($user->topic_rank as $rank) {
                array_push($arr_focus_ranking, $rank->focus_ranking->name);
            }
        }

        $now = Carbon::now()->format('jS \o\f F, Y');

        $data = [
            'cur_date' => $now,
            'user' => $user->exhibitor, 
            'b_owner' => $user->business_owner,
            'b_contact_person' => $user->business_contact_person,
            'nature_business' => $nature_exp,
            'target_buyers' => $target_exp,
            'target_countries' => $export_target_countries,
            'certification' => $certifications_exp,
            'industry_rep_countries' => $exporting_exp,
            'prod_category' => $subcategory_exp,
            'on_input_output' => $arr_char_inputoutput,
            'on_production_process' => $arr_char_prod_process,
            'rank_topics' => $arr_focus_ranking,
            'banner_size' => $user->exhibitor->banner_size,
            'docs' => $user->document
        ];
        // print_r($data);
        // exit;
        $pdf = PDF::loadView('website.registration.exhibitor.summary', $data)->setOptions([
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);
        $pdf->save($path.$filename);
        return true;
    }
}
