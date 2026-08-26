<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\ExhibitorAttendance;

use App\Models\UserAgreement;
use Illuminate\Http\Request;

use App\Mail\SupplierEmailRegistrationValidation;
use App\Models\Exhibitor;
use App\Models\Supplier\Event;
use App\Models\Supplier\ParticipationPackages;
use App\Models\Supplier\ParticipationSpaces;
use App\Models\Supplier\ParticipationBoothSizes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;
use App\Models\NatureBusiness;
use App\Models\TargetBuyer;
use Illuminate\Support\Facades\Validator;
use App\Models\Certification;
use App\Models\SubCategory;
use App\Mail\ExhbitorRegistrationSuccess;
use App\Mail\SupplierRegistrationSuccess;
use App\Mail\SubmitRegistration;
use App\Models\ExhibitorDocument;
use App\Models\Supplier\ParticipationAddOnSelection;
use App\Models\Supplier\ParticipationMandatory;
use App\Models\Supplier\ParticipationBoothSelection;

use App\Models\ExhibitorOnInputOutput;
use App\Models\Supplier\Discounts;
use App\Models\Supplier\AdditionalFees;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Image;
use App\Helpers\QRTokenHelper;
class RegistrationSupplierController extends Controller
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


public function supplier_email_validation(Request $request)
{
    
$request->validate([
    'company_name' => 'required|string|max:150',
    'company_email' => 'required|email|unique:users,email',
    'password' => 'required|string|min:8|confirmed',
]);



$user = new User;
$user->name = Str::upper($request->input('company_name'));
$user->email =  strtolower($request->input('company_email'));

// store hashed password
$user->password = Hash::make($request->input('password'));

// store plain password (not recommended for production)
$user->password_unhash = $request->input('password');

$user->status = 0;
$user->user_group = 5;
$user->reg_token = sha1(time());
$user->save();

if (env('APP_ENV') != 'local') {
    Mail::to($user->email)->send(new SupplierEmailRegistrationValidation($user->id));
} else {
    Mail::to('kgtecson.citem@gmail.com')->send(new SupplierEmailRegistrationValidation($user->id));
}

if (env('SSX_API_SYNC')) {
    $this->citemAPICreate($user->id);
}

return response()->json(true, 200);
}


public function supplier_registration($slug)
{
    $event = Event::where('slug', $slug)->firstOrFail();
    $user  = Auth::guard('supplier')->user();
    $today = now();

    // Check registration window
    if (! $event->registration_start || ! $event->registration_end ||
        $today->lt($event->registration_start) || $today->gt($event->registration_end)) {
        return redirect()->route('supplier.dashboard')
            ->with('error', 'Registration is not available for this event.');
    }

    $fair_code = $event->fair_code;

    // Get or create attendance
    $attendance = ExhibitorAttendance::firstOrCreate(
        [
            'user_id'   => $user->id,
            'fair_code' => $fair_code,
        ],
        [    'qr_token' => QRTokenHelper::generateToken(
            QRTokenHelper::TYPE_SUPPLIER
        ),
            'status' => 0,
            'registration_agreement_id' => 1,
            'registration_agreement_status' => 0,
            'privacy_policy_id' => 3,
            'privacy_policy_status' => 0,
            'information_sharing_id' => 4,
            'information_sharing_status' => 0,
            'conforme_review' => 0,
        ]
    );

    // Restrict access based on status
    switch ($attendance->status) {
        case null:
        case 0:
            // Allowed to register or continue registration
            break;

        case 1:
            return redirect()->route(
                'supplier.dashboard'
            )
                ->with('error', 'Your registration is already approved.');

        case 2:
        case 3:
            return redirect()->route('supplier.dashboard')
                ->with('error', 'Your registration is under review.');

        case 4:
        case 5:
            return redirect()->route('supplier.dashboard')
                ->with('error', 'Registration is not available.');
        
        default:
            return redirect()->route('supplier.dashboard')
                ->with('error', 'You cannot access this registration.');
    }

    // Create or update exhibitor record for this fair
    $exhibitorData = [
        'uid'       => $user->id,
        'fair_code' => $fair_code,
    ];

    $exhibitorValues = [
        'co_name'  => Str::upper($user->name),
        'co_email' => Str::of($user->email)->lower(),
        'slug'     => Str::slug($user->name),
    ];

    Exhibitor::updateOrCreate($exhibitorData, $exhibitorValues);

    // $this->citemAPICreateAttendanceForFair($user->id, $fair_code);


    // Agreements
    $agreement = UserAgreement::select('id', 'type', 'status')->get();

    return view('supplier.registration.registration', [
        'event'      => $event,
        'id'         => $user->id,
        'agreement'  => $agreement,
        'attendance' => $attendance,
    ]);
}



public function user_information($id, $fair_code)
{
    try {
        Log::info('user_information() called', ['id' => $id, 'fair_code' => $fair_code]);

        // Fetch user
        $user = User::find($id);
        if (! $user) {
            Log::error('User not found', ['id' => $id]);
            abort(404, 'User not found');
        }

        // Log raw user
        Log::info('Fetched user record', ['user' => $user->toArray()]);

        if ($user->user_group === 5) {
            // Supplier/Exhibitor
            Log::info('Loading exhibitor for fair_code', ['user_id' => $user->id, 'fair_code' => $fair_code]);

            $exhibitor = $user->exhibitorForFair($fair_code);
            if (! $exhibitor) {
                Log::warning('No exhibitor found for this fair', ['user_id' => $user->id, 'fair_code' => $fair_code]);
                abort(404, 'Exhibitor not found for this fair code');
            }

            $user['exhibitor_type'] = $exhibitor->exhibitor_type ?? null;
            $user['last_participated'] = $exhibitor->last_participated_year ?? null;
            $user['fascia_name'] = $exhibitor->fascia_name ?? '';
             $attendance = $user->exhibitorAttendanceForFair($fair_code);

             
        


            $pitching_competition_selection = $user
                ->pitchingSelectionsForFair($fair_code)
                ->with('pitchingSessionCategories')
                ->get();



            $user->setRelation('exhibitor', $exhibitor);
            // Eager-load relations, scoping owner/contact_person to the requested fair_code
            $user->load([
                'products' => function ($q) use ($fair_code){
                    $q->where('fair_code', $fair_code);
                },
                'business_owner' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'business_contact_person' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'certification' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'category_subcategory'=> function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'on_input_output' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'on_production_process' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'topic_rank',
                'nature_business' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },
                'topic_pick'=> function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                }, 
                'document'=> function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                },  
                'target_buyer' => function ($q) use ($fair_code) {
                    $q->where('fair_code', $fair_code);
                }, 
            ]);

              $user['step4'] = [
                'participation_type' => $attendance->participation_type ?? null,
                'conference_response' => $attendance->conference_response ?? null,
                'sponsorship_response' => $attendance->sponsorship_response ?? null,
                  'pitching_competition_selection' => $pitching_competition_selection->pluck('pitching_session_category_id')->toArray(),
            ];

            // Format categories
            if ($user->category_subcategory) {
                $catsub = [];
                foreach ($user->category_subcategory as $key => $category) {
                    $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $catsub;
            }

             // Format input/output
            if ($user->sdg) {
                $user['sdg'] = $user->sdg->map(fn($sdg) => [
                    'id' => $sdg->id,
                    'name' => $sdg->product_char_sdg->name,
                ]);
            }

            // Format input/output
            if ($user->on_input_output) {
                $user['inout'] = $user->on_input_output->map(fn($inout) => [
                    'id' => $inout->id,
                    'name' => $inout->product_char_inputoutput->name,
                ]);
            }

            // Format production process
            if ($user->on_production_process) {
                $user['process'] = $user->on_production_process->map(fn($proc) => [
                    'id' => $proc->id,
                    'name' => $proc->product_char_prod_process->name,
                ]);
            }

            //Nature of business
            if ($user->nature_business) {
                $user['nature_business'] = $user->nature_business->map(fn($nb) => [
                    'id'   => $nb->id,
                    'name' => $nb->name,
                ])->toArray();
            }

            //Target Buyer
            if ($user->target_buyer) {
                $user['target_buyer'] = $user->target_buyer->map(fn($tb) => [
                    'id'   => $tb->id,
                    'name' => $tb->buyer->name ?? null, // comes from joined table
                ])->toArray();
            }

            // Topic picks
                if ($user->topic_pick) {
                    $user['topic_picks'] = $user->topic_pick->map(function ($pick) {
                        return [
                            'id' => $pick->topic_id,
                            'name' => $pick->focus_topic ? $pick->focus_topic->name : null,
                        ];
                    });
                }


            // Masthead & Logo
            if ($user->masthead) {
                $user['masthead'] = pathinfo('/storage/exhibitors/mastheads/' . $user->masthead);
            }
            if ($user->logo) {
                $user['logo'] = pathinfo('/storage/exhibitors/logos/' . $user->logo);
            }

            // Documents
            $docs = [
                'dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate', 
                'institutional_catalog', 'business_certification', 'food_or_environmental_certification'
            ];
            foreach ($docs as $key => $docField) {
                if (!empty($user->document->{$docField})) {
                    $user['doc'.($key+1)] = pathinfo($user->document->{$docField});
                    $user['doc'.($key+1).'_url'] = Storage::url($user->document->{$docField});
                    $user['doc'.($key+1).'_filesize'] = Storage::size($user->document->{$docField});
                }
            }

        } else {
            // Buyer
            Log::info('Loading buyer relations for user', ['id' => $user->id]);
            $user->load([
                'buyer',
                'category_subcategory',
                'nature_business',
                'participation_goal',
                'learn_about_event',
            ]);

            if ($user->category_subcategory) {
                $catsub = [];
                foreach ($user->category_subcategory as $key => $category) {
                    $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $catsub;
            }
        }

        // Final log of all user data
        try {
            Log::info('Final user data:', ['user' => $user->toArray()]);
        } catch (\Throwable $e) {
            Log::error('Failed to serialize user for logging', ['error' => $e->getMessage()]);
        }

        return response()->json($user, 200);

    } catch (\Throwable $e) {
        Log::error('Error in user_information()', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}

public function user_docs($id, $fair_code)
{
    try {
        Log::info('getUserDocuments() called', ['user_id' => $id, 'fair_code' => $fair_code]);

        // Fetch user
        $user = User::find($id);
        if (!$user) {
            Log::warning('User not found', ['user_id' => $id]);
            abort(404, 'User not found');
        }

        // Load document relation scoped by fair_code
        $user->load(['document' => function ($q) use ($fair_code) {
            $q->where('fair_code', $fair_code);
        }]);

        $docs = [
            'dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate',
            'institutional_catalog', 'business_certification', 'food_or_environmental_certification'
        ];

        $result = [];

        foreach ($docs as $key => $docField) {
            if (!empty($user->document->{$docField})) {
                $result['doc'.($key+1)] = pathinfo($user->document->{$docField});
                $result['doc'.($key+1).'_url'] = Storage::url($user->document->{$docField});
                $result['doc'.($key+1).'_filesize'] = Storage::size($user->document->{$docField});
            }
        }

        Log::info('Fetched documents for user', ['user_id' => $id, 'docs' => $result]);

        return response()->json($result, 200);

    } catch (\Throwable $e) {
        Log::error('Error in getUserDocuments()', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to fetch documents'], 500);
    }
}


public function supplier_store(Request $request){

    $user = User::findOrFail($request->input('user_id'));
    $authUserId = Auth::guard('supplier')->user();

    $event_fair_code = $request->input('event_fair_code');
  $attendance = $user->exhibitorAttendanceForFair($event_fair_code);

  $event = Event::where('fair_code', $event_fair_code)->first();
$event_name = $event->event_name ?? $event_fair_code; 

if ($request->input('step') == 1) {
    // STEP 1: Logo, Masthead, Exhibitor info
    $step1_decode = json_decode($request->input('step1_data'), true);


    
    // Server-side validation to prevent overly long/payloads
    $validator = Validator::make($step1_decode, [
        'exhibitor_type' => 'required|integer|in:1,2',
        'last_participated' => [
            'nullable',
            'integer',
            'min:1900',
            'max:' . date('Y'),
            'required_if:exhibitor_type,2',
        ],
        'fascia_name' => 'required|string|max:100',
        'directory_name' => 'required|string|max:100',
        'co_details' => 'required|string|max:2000',
        'mission' => 'required|string|max:1000',
        'env_conservation' => 'nullable|string|max:1000',
        'country_code' => 'nullable',
        'area_code' => 'nullable|string|max:5',
        'phone_no' => 'nullable|string|max:12',
        'country_code_mobile' => 'required',
        'mobile_no' => 'required|string|max:12',
        'website' => 'nullable|string|max:195',
        'facebook' => 'nullable|string|max:195',
        'twitter' => 'nullable|string|max:195',
        'instagram' => 'nullable|string|max:195',
        'linkedin' => 'nullable|string|max:195',
        'other_social' => 'nullable|string|max:195',
        'moa_country' => 'required',
        'moa_state' => 'required|string|max:95',
        'moa_city' => 'required|string|max:95',
        'moa_zipcode' => 'required|string|max:15',
        'moa_region' => 'nullable|string|max:95',
        'moa_street' => 'required|string|max:195',
        'fa_country' => 'required',
        'fa_state' => 'required|max:95',
        'fa_city' => 'required|max:95',
        'fa_zipcode' =>'required|max:15',
        'fa_region' => 'nullable|max:95',
        'fa_street' => 'required|max:195',
      
    ], [
        'required' => ':attribute is required.',
        'string'   => ':attribute must be a valid text.',
        'max'      => ':attribute must not exceed :max characters.',
    ],
    [
        'directory_name' => 'Directory name',
        'co_details' => 'Company details',
        'mission' => 'Mission',
        'env_conservation' => 'Environmental conservation',
        'country_code' => 'Country code (Phone)',
        'area_code' => 'Area code',
        'phone_no' => 'Phone number',
        'country_code_mobile' => 'Country code (Mobile)',
        'mobile_no' => 'Mobile number',
        'website' => 'Website',
        'facebook' => 'Facebook URL',
        'twitter' => 'Twitter URL',
        'instagram' => 'Instagram URL',
        'linkedin' => 'LinkedIn URL',
        'other_social' => 'Other Social Media',
        'moa_country' => 'Main Office Address Country',
        'moa_state' => 'Main Office Address State',
        'moa_city' => 'Main Office Address City',
        'moa_zipcode' => 'Main Office Address Zipcode',
        'moa_region' => 'Main Office Address Region',
        'moa_street' => 'Main Office Address Street',
        'fa_country' => 'Factory Address Country',
        'fa_state' => 'Factory Address State',
        'fa_city' => 'Factory Address City',
        'fa_zipcode' => 'Factory Address Zipcode',
        'fa_region' => 'Factory Address Region',
        'fa_street' => 'Factory Address Street',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }


    $destinationPath = storage_path('app/public/exhibitors/');

    // Logo
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
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

    // Masthead
    if ($request->hasFile('masthead')) {
        $masthead = $request->file('masthead');
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

    $user->save();

        // Only fetch the exhibitor for this fair_code
    $exhibitor = $user->exhibitorForFair($event_fair_code);
    if (! $exhibitor) {
        // Create a new exhibitor if it doesn't exist for this fair
        $exhibitor = $user->exhibitor()->create(['fair_code' => $event_fair_code]);
    }

// Update exhibitor details
    $exhibitor->update([
        'exhibitor_type' => $step1_decode['exhibitor_type'],
        'last_participated_year' => $step1_decode['last_participated'] ?? null,
        'fascia_name' => Str::title($step1_decode['fascia_name']),
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
        'moa_street' => $step1_decode['moa_street'], 
        'updated_by' => $authUserId->id,
       
    ]);

    // if (env('SSX_API_SYNC')) {
        // $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
        // $this->citemAPIUpdateExhibitor($user->id );
    // }
    } elseif ($request->input('step') == 'add_product') {
        $prod_info = json_decode($request->input('prod_info'), true);

        // Validate product inputs
        $prodValidator = Validator::make($prod_info, [
            'prod_name' => 'required|string|max:95',
            'prod_details' => 'nullable|string|max:500',
            'store_url' => 'nullable|url|max:200',
        ],  [
        'required' => ':attribute is required.',
        'string'   => ':attribute must be valid text.',
        'max'      => ':attribute must not exceed :max characters.',
        'url'      => ':attribute must be a valid URL.',
    ],
    // ✅ Custom readable attribute names
    [
        'prod_name' => 'Product name',
        'prod_details' => 'Product details',
        'store_url' => 'Store URL',
    ]);
        if ($prodValidator->fails()) {
            return response()->json(['errors' => $prodValidator->errors()], 422);
        }

        $product = $user->products()->updateOrCreate(
    [
        'id' => $request->input('product_id'),
        'fair_code' => $event_fair_code, // Ensure product matches this fair
    ],
    [
        'name' => $prod_info['prod_name'],
        'fair_code' => $event_fair_code,
        'slug' => Str::of($prod_info['prod_name'])->slug('-'),
        'description' => $prod_info['prod_details'],
        'store_url' => $prod_info['store_url'],
        'status' => 2,
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
            'status' => 2
        ]);
    } elseif ($request->input('step') == 2) {
        $step2_decode = json_decode($request->input('step2_data'), true);
        $validator2 = Validator::make($step2_decode, [
            'salutation' => 'nullable|string|max:10',
            'fname' => 'required|string|max:95',
            'lname' => 'required|string|max:95',
            'mi' => 'nullable|string|max:4',
            'designation' => 'required|string|max:95',
            'email' => 'required|email|max:145',
            'country_code_mobile_bo' => 'required',
            'mobile_no_bo' => 'required|string|max:15',
            'bcp_salutation' => 'nullable|string|max:10',
            'bcp_fname' => 'required|string|max:95',
            'bcp_lname' => 'required|string|max:95',
            'bcp_mi' =>  'nullable|string|max:4',
            'bcp_designation' => 'required|string|max:95',
            'bcp_email' => 'required|email|max:145',
            'bcp_country_code' => 'required',
            'bcp_mobile_no' => 'required|string|max:12',
        ],[], [
        'salutation' => 'Salutation',
        'fname' => 'First Name',
        'lname' => 'Last Name',
        'mi' => 'Middle Initial',
        'designation' => 'Designation',
        'email' => 'Email',
        'country_code_mobile_bo' => 'Mobile Country Code',
        'mobile_no_bo' => 'Mobile Number',
        'bcp_salutation' => 'Salutation',
        'bcp_fname' => 'First Name',
        'bcp_mi' => 'Middle Initial',
        'bcp_lname' => 'Last Name',
        'bcp_designation' => 'Designation',
        'bcp_email' => 'Email',
        'bcp_country_code' => 'Mobile Country Code',
        'bcp_mobile_no' => 'Mobile Number',
    ]);
        if ($validator2->fails()) {
            return response()->json(['errors' => $validator2->errors()], 422);
        }
        $user->business_owner()->updateOrCreate(
            [
                'uid' => $user->id,
                    'fair_code' => $event_fair_code, 
            ],
            [
                'fair_code' => $event_fair_code,
                'salutation' => $step2_decode['salutation'],
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
                'uid' => $user->id,
                    'fair_code' => $event_fair_code, 
            ],
            [
                'fair_code' => $event_fair_code,
                'salutation' => $step2_decode['bcp_salutation'],
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
        
    // if (env('SSX_API_SYNC')) {
        // $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
                // $this->citemAPIUpdateExhibitor($user->id );
    // }

    } elseif ($request->input('step') == 3) {
$step3_decode = json_decode($request->input('step3_data'), true);

$validator3 = Validator::make(
    $step3_decode,
    [
        'business_type' => 'required|integer',
        'company_size' => 'required|integer',
        'annual_sales_volume' => 'required|integer',
        'organization_type' => 'required|integer',
        'product_promoted' => 'required|string|max:410',
        'nature_business' => 'required|array',
        'target_buyer' => 'nullable|array|max:50',
        'certification' => 'nullable|array|max:50',
        'category' => 'nullable|array|max:200',
        'sdg' => 'required|array',
        'input_ouput' => 'nullable|array',
        'production_process' => 'nullable|array',
        'sustainability_topics' => 'nullable|array',
    ],

    [
        'required' => ':attribute is required.',
        'integer' => ':attribute must be a valid number.',
        'string' => ':attribute must be valid text.',
        'max' => ':attribute must not exceed :max items.',
        'array' => ':attribute must be an array.',
    ],
 
    [
        'business_type' => 'Business type',
        'company_size' => 'Company size',
        'annual_sales_volume' => 'Annual sales volume',
        'organization_type' => 'Organization type',
        'product_promoted' => 'Product promoted',
        'nature_business' => 'Nature of business',
        'target_buyer' => 'Target buyer(s)',
        'certification' => 'Certification(s)',
        'category' => 'Product category',
        'sdg' => 'Sustainable Development Goals (SDG) Alignment',
        'input_ouput' => 'Input & Output',
        'production_process' => 'Production process',
        'sustainability_topics' => 'Sustainability topics',
    ]
);


if ($validator3->fails()) {
    return response()->json(['errors' => $validator3->errors()], 422);
}

Log::info('Step 3 decoded data:', $step3_decode);
Log::info('Processing Step 3 for user', ['user_id' => $user->id, 'fair_code' => $event_fair_code]);

// Update Exhibitor
$exhibitor = $user->exhibitor()->updateOrCreate(
    [
        'uid' => $user->id,
        'fair_code' => $event_fair_code,
    ],
    [
        'business_type_id'        => $step3_decode['business_type'],
        'start_up' => data_get($step3_decode, 'start_up', false) ? 1 : 0,
        'company_size_id'         => $step3_decode['company_size'],
        'annual_sales_volume_id'  => $step3_decode['annual_sales_volume'],
        'direct_workers'          => $step3_decode['direct'],
        'indirect_workers'        => $step3_decode['indirect'],
        'target_country_export_1' => $step3_decode['target_country_1'],
        'target_country_export_2' => $step3_decode['target_country_2'],
        'target_country_export_3' => $step3_decode['target_country_3'],
        'organization_type_id'    => $step3_decode['organization_type'],
        'industry_rep'            => $step3_decode['industry_representation'],
        'ir_country_exporting_1'  => $step3_decode['exporting_country_1'] ?: null,
        'ir_country_exporting_2'  => $step3_decode['exporting_country_2'] ?: null,
        'ir_country_exporting_3'  => $step3_decode['exporting_country_3'] ?: null,
        'product_promoted'        => $step3_decode['product_promoted'],
         'updated_by' => $authUserId->id,
    ]
);

    // Clear participation type if start_up = 1
    if ($step3_decode['start_up'] == 1) {
        if ($attendance) {
            $attendance->timestamps = false; 
            $attendance->participation_type = 1;
            $attendance->save();
            $attendance->timestamps = true;
        }
    }

Log::info('Exhibitor updated/created', $exhibitor->toArray());

/*
|--------------------------------------------------------------------------
| NATURE BUSINESS
|--------------------------------------------------------------------------
*/
$user->nature_business()
->where('fair_code', $event_fair_code)
->delete(); // ✅ Deletes all existing entries for this user + fair

$arr_nature_business = collect($step3_decode['nature_business'] ?? [])
->map(function ($nb) use ($step3_decode, $event_fair_code) {
    $nature_business = NatureBusiness::find($nb);
     if (!$nature_business) return null;

     $remarks = $nature_business->id === 16
            ? Str::title($step3_decode['nature_business_others'])
            : $nature_business->name;


    return [
        'nature_business_id' => $nature_business->id,
        'fair_code'          => $event_fair_code,
        'remarks'            => $remarks,
    ];
})
->filter()
->unique(fn($item) => $item['nature_business_id'].'-'.$item['fair_code']) // optional: avoid dupes
->values()
->toArray();

$user->nature_business()->createMany($arr_nature_business);

Log::info('Nature business saved', $arr_nature_business);
/*
|--------------------------------------------------------------------------
| TARGET BUYERS
|--------------------------------------------------------------------------
*/
$user->target_buyer()->where('fair_code', $event_fair_code)->delete();
$arr_target_buyers = collect($step3_decode['target_buyer'] ?? [])
    ->map(function ($target) use ($step3_decode, $event_fair_code) {
        $target_buyer = TargetBuyer::find($target);
        if (!$target_buyer) return null;

        $remarks = $target_buyer->id === 6
            ? Str::title($step3_decode['target_buyer_others'])
            : $target_buyer->name;

        return [
            'target_buyer_id' => $target_buyer->id,
            'fair_code'       => $event_fair_code,
            'remarks'         => $remarks,
        ];
    })
    ->filter()
    ->unique(fn($item) => $item['target_buyer_id'].'-'.$item['fair_code'])
    ->toArray();
$user->target_buyer()->createMany($arr_target_buyers);
Log::info('Target buyers saved', $arr_target_buyers);

/*
|--------------------------------------------------------------------------
| CERTIFICATIONS
|--------------------------------------------------------------------------
*/
$user->certification()->where('fair_code', $event_fair_code)->delete();
$arr_certifications = collect($step3_decode['certification'] ?? [])
    ->map(function ($cert) use ($step3_decode, $event_fair_code) {
        $certification = Certification::find($cert);
        if (!$certification) return null;

        $remarks = $certification->id === 14
            ? Str::title($step3_decode['certification_others'])
            : $certification->name;

        return [
            'certification_id' => $certification->id,
            'fair_code'        => $event_fair_code,
            'remarks'          => $remarks,
        ];
    })
    ->filter()
    ->unique(fn($item) => $item['certification_id'].'-'.$item['fair_code'])
    ->toArray();
$user->certification()->createMany($arr_certifications);
Log::info('Certifications saved', $arr_certifications);

/*
|--------------------------------------------------------------------------
| CATEGORIES & SUB-CATEGORIES
|--------------------------------------------------------------------------
*/
$user->category_subcategory()->where('fair_code', $event_fair_code)->delete();
$arr_categories = collect($step3_decode['category'] ?? [])
    ->map(function ($sub) use ($event_fair_code) {
        $sub_category = SubCategory::find($sub);
        return $sub_category ? [
            'category_id'          => $sub_category->category_id,
            'fair_code'            => $event_fair_code,
            'category_remarks'     => $sub_category->category->name,
            'sub_category_id'      => $sub_category->id,
            'sub_category_remarks' => $sub_category->name,
        ] : null;
    })
    ->filter()
    ->toArray();
$user->category_subcategory()->createMany($arr_categories);
Log::info('Categories & sub-categories saved', $arr_categories);

/*
|--------------------------------------------------------------------------
| INPUT / OUTPUT
|--------------------------------------------------------------------------
*/
$user->on_input_output()
->where('fair_code', $event_fair_code)
->delete(); // Deletes all existing entries for this user + fair

$arr_input_output = collect($step3_decode['input_ouput'] ?? [])
->map(function ($id) use ($event_fair_code) {
    return [
        'fair_code'       => $event_fair_code,
        'input_output_id' => $id,
    ];
})
->filter() // remove nulls or invalid items
->unique(fn($item) => $item['fair_code'] . '-' . $item['input_output_id']) // avoid duplicates
->values()
->toArray();

$user->on_input_output()->createMany($arr_input_output);

Log::info('Input/Output saved', $arr_input_output);


/*
|--------------------------------------------------------------------------
| PRODUCTION PROCESS
|--------------------------------------------------------------------------
*/
$user->on_production_process()
->where('fair_code', $event_fair_code)
->delete(); // ✅ Delete all existing entries for this user + fair

$arr_production_process = collect($step3_decode['production_process'] ?? [])
->map(function ($pprocess) use ($step3_decode, $event_fair_code) {
    $pp_remarks = $pprocess === 3
        ? Str::title($step3_decode['production_process_others'] ?? '')
        : null;

    return [
        'production_process_id' => $pprocess,
        'fair_code'             => $event_fair_code,
        'other_certification'   => $pp_remarks,
    ];
})
->filter() // ✅ Remove null/invalid
->unique(fn($item) => $item['fair_code'] . '-' . $item['production_process_id']) 
->values()
->toArray();

if (!empty($arr_production_process)) {
$user->on_production_process()->createMany($arr_production_process);
}

Log::info('Production process saved', $arr_production_process);

/*
|--------------------------------------------------------------------------
| TOPIC PICK
|--------------------------------------------------------------------------
*/
$user->topic_pick()->where('fair_code', $event_fair_code)->delete();
$arr_topic_picks = collect($step3_decode['sustainability_topics'] ?? [])
    ->map(fn($topicId) => [
        'topic_id'  => $topicId,
        'fair_code' => $event_fair_code,
    ])
    ->toArray();
$user->topic_pick()->createMany($arr_topic_picks);
Log::info('Topic picks saved', $arr_topic_picks);

/*
|--------------------------------------------------------------------------
| SDG
|--------------------------------------------------------------------------
*/
$user->sdg()
    ->where('fair_code', $event_fair_code)
    ->delete();

$arr_sdgs = collect($step3_decode['sdg'] ?? [])
    ->map(function ($sdgId) use ($event_fair_code) {
        return [
            'sdg_id'    => $sdgId,
            'fair_code' => $event_fair_code,
        ];
    })
    ->filter()
    ->unique(function ($item) {
        return $item['fair_code'] . '-' . $item['sdg_id'];
    })
    ->values()
    ->toArray();

if (!empty($arr_sdgs)) {
    $user->sdg()->createMany($arr_sdgs);
}

Log::info('SDGs saved', $arr_sdgs);

// if (env('SSX_API_SYNC')) {
    // $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
        // $this->citemAPIUpdateExhibitor($user->id );
// }


Log::info('Step 3 processing finished', ['user_id' => $user->id]);
    return response()->json([
        'business_type' => $exhibitor->business_type_id,
        'start_up' => $exhibitor->start_up,
        'participation_type' => $attendance->participation_type,
    ], 200);
    } elseif ($request->input('step') == 4) {

        Log::info('Step 4 participation_type', [
        'user_id' => $user->id,
        'fair_code' => $event_fair_code,
        'value' => $step4_decode['participation_type'] ?? null
    ]);

    $step4_decode = json_decode($request->input('step4_data'), true);

    // Update banner size on exhibitor
    $user->exhibitor()->update([
        'banner_size_id' => $step4_decode['banner_size'] ?? null
    ]);



    if ($attendance) {
    $attendance->timestamps = false; 
    $attendance->conference_response = $step4_decode['conference_response'] ?? null;
    $attendance->participation_type = $step4_decode['participation_type'] ?? null;
    $attendance->sponsorship_response = $step4_decode['sponsorship_response'] ?? null;
    $attendance->save();
    $attendance->timestamps = true;
}
    // if (env('SSX_API_SYNC')) {
        // $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
        // $this->citemAPIUpdateExhibitor($user->id );
    // }
    } elseif ($request->input('step') == 5) {
    // STEP 5: Handle Documents Upload
    $docFields = [
        'doc1' => 'dti_sec',
        'doc2' => 'bir',
        'doc3' => 'lto',
        'doc4' => 'cpr',
        'doc5' => 'other_food_certificate',
        'doc6' => 'institutional_catalog',
        'doc7' => 'business_certification',
        'doc8' => 'food_or_environmental_certification'
    ];

    // Validation rules
    $docRules = [];
    foreach ($docFields as $input => $column) {
        $docRules[$input] = 'nullable|mimes:pdf,jpg,jpeg,png|max:1024';
    }

    $docValidator = Validator::make($request->all(), $docRules);
    if ($docValidator->fails()) {
        return response()->json(['errors' => $docValidator->errors()], 422);
    }

    $exhibitor = $user->exhibitorForFair($event_fair_code);
    $businessType = optional($exhibitor)->business_type_id;

    $existingDocs = $user->exhibitorDocumentFor($event_fair_code)->first();
    $docs = [];

    foreach ($docFields as $input => $column) {
        $currentValue = optional($existingDocs)->{$column};

        if ($request->hasFile($input)) {
            if ($currentValue && Storage::exists($currentValue)) {
                Storage::delete($currentValue);
            }
            $docs[$column] = $request->file($input)->store('public/documents', 'local');
        } else {
            $docs[$column] = $currentValue;
        }
    }

    // Nullify irrelevant fields based on business type
    $type3 = ['dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate'];
    $type1and2 = ['business_certification', 'food_or_environmental_certification'];

    if ($businessType == 3) {
        foreach ($type3 as $column) {
            if (!empty($docs[$column]) && Storage::exists($docs[$column])) {
                Storage::delete($docs[$column]);
            }
            $docs[$column] = null;
        }
    } else {
        foreach ($type1and2 as $column) {
            if (!empty($docs[$column]) && Storage::exists($docs[$column])) {
                Storage::delete($docs[$column]);
            }
            $docs[$column] = null;
        }
    }

    // Update or create documents
    if ($existingDocs) {
        foreach ($docs as $key => $value) {
            $existingDocs->{$key} = $value;
        }
        $existingDocs->save();
    } else {
        $user->document()->create(array_merge(
            ['uid' => $user->id, 'fair_code' => $event_fair_code],
            $docs
        ));
    }


    return response()->json(true, 200);

} else {
    // STEP 6: Agreements & Final Submission
    $exhibitor = $user->exhibitorForFair($event_fair_code);

    $data = [];
    if ($request->filled('registration_agreement_id')) {
        $data['registration_agreement_id'] = $request->input('registration_agreement_id');
        $data['registration_agreement_status'] = 1;
        $data['registration_agreement_agreed_at'] = now();
    }

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
        ExhibitorAttendance::updateOrCreate(
            [
                'user_id'   => $user->id,
                'fair_code' => $event_fair_code,
            ],
            $data
        );
    }

    // Generate PDF and send email
    // $pdfPath = $this->generate_pdf($user->id, $event_fair_code);

    $recipientEmail = env('APP_ENV') != 'local'
        ? ($exhibitor->co_email ?? $user->email)
        : 'kgtecson.citem@gmail.com';

    Mail::to($recipientEmail)
        ->send(new SupplierRegistrationSuccess($user, $exhibitor, $event_fair_code, $event_name, null));



    $BCC_Officer_Suppliers =  env('APP_ENV') != 'local' ? $this->parseEmailList(env('BCC_Officer_Suppliers')) : 'kgtecson.citem@gmail.com';

   Mail::to($BCC_Officer_Suppliers)->send(new SubmitRegistration($user, $exhibitor , $event));


    // if (env('SSX_API_SYNC')) {
        // $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
                // $this->citemAPIUpdateExhibitor($user->id );
        // $this->citemAPIValidateStatus($user->email, 'pending', $user->user_group);
    // }

        // Update exhibitor attendance status to saved
    $user->exhibitorAttendances()->updateOrCreate(
        ['fair_code' => $event_fair_code],
        ['status' => 2]
    );


    return response()->json(true, 200);
}


}


public function generate_pdf($id, $fair_code)
{
    try {
        Log::info('generate_pdf() called', ['id' => $id, 'fair_code' => $fair_code]);

        // Fetch user
        $user = User::find($id);
        if (!$user) {
            Log::error('User not found', ['id' => $id]);
            return false;
        }

        // Only for Exhibitors/Suppliers
        if ($user->user_group === 5) {
            Log::info('Loading exhibitor for fair_code', ['user_id' => $user->id, 'fair_code' => $fair_code]);

            $exhibitor = $user->exhibitorForFair($fair_code);
            if (!$exhibitor) {
                Log::warning('No exhibitor found for this fair', ['user_id' => $user->id, 'fair_code' => $fair_code]);
                return false;
            }

             $attendance_info = $user->exhibitorAttendanceForFair($fair_code);

            $event = Event::where('fair_code', $fair_code)->first();
            if (!$event) {
                Log::warning('No event found for this fair_code', ['fair_code' => $fair_code]);
                $event = null;
            }

            $user->setRelation('exhibitor', $exhibitor);

            // Load required relations
            $user->load([
                'products',
                'business_owner',
                'business_contact_person',
                'certification',
                'category_subcategory',
                'topic_rank.focus_ranking',
                'topic_pick',
                'document',  
            ]);

            // ✅ Fetch Nature Business via pivot table
            $natureBusiness = DB::table('exhibitors_buyers_nature_businesses as ebnb')
                ->join('nature_businesses as nb', 'ebnb.nature_business_id', '=', 'nb.id')
                ->where('ebnb.uid', $user->id)
                ->where('ebnb.fair_code', $fair_code)
                ->pluck('nb.name')
                ->toArray();

            // ✅ Fetch Target Buyers via pivot table
            $targetBuyers = DB::table('exhibitors_target_buyers as etb')
                ->join('target_buyers as tb', 'etb.target_buyer_id', '=', 'tb.id')
                ->where('etb.uid', $user->id)
                ->where('etb.fair_code', $fair_code)
                ->pluck('tb.name')
                ->toArray();


                
$user->setRelation('on_input_output', $user->inputOutputForFair($fair_code)
    ->with('product_char_inputoutput')->get());

$user->setRelation('on_production_process', $user->productionProcessForFair($fair_code)
    ->with('product_char_prod_process')->get());

$user->setRelation('topic_pick', $user->topicPicksForFair($fair_code)
    ->with('focus_topic')->get());

        $cart = Exhibitor::with([
        'participationSelections' => function ($q) use ($fair_code) {
            $q->where('fair_code', $fair_code);
        },
        'participationSelections.package:id,title,sub_title,booth_details',
        'participationSelections.space:id,name',
        'participationSelections.size',
    ])
    ->where('uid', $user->id)
    ->first();


            $user['nature_business'] = $natureBusiness;
            $user['target_buyer'] = $targetBuyers;


            // Format cart items to pass to Blade
        $cartItems = [];
        if ($cart && $cart->participationSelections) {
            $cartItems = $cart->participationSelections->map(function ($item) {
                return [
                    'id' => $item->id,
                    'package_title' => $item->package->title ?? '',
                    'package_sub_title' => $item->package->sub_title ?? '',
                    'space_name' => $item->space->name ?? '',
                    'booth_details' => $item->package->booth_details ?? '',
                    'booth_size_name' => $item->booth_size_name ?? '',
                    'booth_qty' => $item->booth_qty  ?: 0,
                    'total_participation' => $item->total_participation ?? 0,
                    'discount' => $item->discount ?? 0,
                    'discount_remarks' => $item->discount_remarks ?? '',
                    'total_amount_due' => $item->total_amount_due ?? 0,
                    'currency' => $item->currency ?? '',
                ];
            })->toArray();
        }

        // Discounts
        $discounts = Discounts::where('ff_code', $user->id)
        ->where('fair_code', $fair_code)
        ->get();


        $discountItems = $discounts->map(function ($d) {
            return [
                'remarks' => $d->remarks,
                'amount'  => $d->amount,
                'currency' => $d->currency,
                'type' => $d->type, // e.g. fixed or percent
            ];
        })->toArray();
        // End Discounts



        
        // Additional Fees
        $additionalFees = AdditionalFees::where('ff_code', $user->id)
        ->where('fair_code', $fair_code)
        ->get();


        $additionalFeesItems = $additionalFees->map(function ($d) {
            return [
                'remarks' => $d->remarks,
                'amount'  => $d->amount,
                'currency' => $d->currency,
                'type' => $d->type, // e.g. fixed or percent
            ];
        })->toArray();

        // End Additional Fees


        $mandatory = ParticipationMandatory::where('business_type_id', $exhibitor->business_type_id)->first();

        $mandatoryData = null;
        if ($mandatory) {
            $mandatoryData = [
                'id'       => $mandatory->id,
                'details'  => $mandatory->details,
                'price'    => $mandatory->price,
                'currency' => $mandatory->currency,
            ];
        }

        

        $addonSelections = ParticipationAddOnSelection::with(['addOn', 'addOnRates'])
        ->where('ff_code', $user->id) // 🔸 Check this column name, should probably be 'uid'
        ->where('fair_code', $fair_code)
        ->get();
        $addonItems = [];
        
        if ($addonSelections->isNotEmpty()) {
    $businessTypeId = optional($user->exhibitorForFair($fair_code))->business_type_id;

    $addonItems = $addonSelections->map(function ($selection) use ($businessTypeId) {
        $rate = $selection->addOnRates
            ->when($businessTypeId, function ($query) use ($businessTypeId) {
                return $query->where('business_type_id', $businessTypeId);
            })
            ->first();

        return [
            'id' => $selection->id,
            'addon_name' => $selection->addOn->name ?? 'N/A',
            'unit' => $selection->addOn->unit ?? 'N/A',
            'qty' => $selection->qty ?? 0,
            'qty_type' => $selection->addOn->qty_type ?? 'N/A',
            'limit_per_exhibitor' => $selection->addOn->limit_per_exhibitor ?? 'N/A',
            'currency' => $rate->currency ?? 'N/A',
            'rate_cost' => $rate->cost ?? 0,
            'total_amount_due' => $selection->total_amount_due ?? 0,
            
        ];
    })->toArray();
}

            // Format category/subcategory
            if ($user->category_subcategory) {
                $catsub = [];
                foreach ($user->category_subcategory as $key => $category) {
                    $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $catsub;
            }

            // Format input/output
            if ($user->on_input_output) {
                $user['inout'] = $user->on_input_output->map(fn($inout) => [
                    'id' => $inout->id,
                    'name' => $inout->product_char_inputoutput->name,
                ]);
            }

            // Format production process
            if ($user->on_production_process) {
                $user['process'] = $user->on_production_process->map(fn($proc) => [
                    'id' => $proc->id,
                    'name' => $proc->product_char_prod_process->name,
                ]);
            }




            // Load exhibitor relations
            $exhibitor->load([
                'factory_country',
                'main_country',
                'country_target_buyer_export_1',
                'country_target_buyer_export_2',
                'country_target_buyer_export_3',
                'country_exporting_to_1',
                'country_exporting_to_2',
                'country_exporting_to_3',
                'business_registration_type',
                'company_size',
                'annual_sales_volume',
                'banner_size',
            ]);


    // Documents
           $documentForFair = $user->exhibitorDocumentFor($fair_code)->first();
     
            $user->setRelation('category_subcategory',$user->categorySubcategoryForFair($fair_code)->get());


                $docs = [
                    'dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate', 
                    'institutional_catalog', 'business_certification'
                ];
              foreach ($docs as $key => $docField) { if (!empty($documentForFair->{$docField}) && Storage::exists($documentForFair->{$docField})) { $user['doc'.($key+1)] = pathinfo($documentForFair->{$docField}); $user['doc'.($key+1).'_url'] = Storage::url($documentForFair->{$docField}); $user['doc'.($key+1).'_filesize'] = Storage::size($documentForFair->{$docField}); } }
            // PDF directory setup
            $path = storage_path('app/public/exhibitor_summary/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $filename = "{$exhibitor->slug}_{$user->id}_{$fair_code}.pdf";
            $fullPath = $path . $filename;

            // Build display values
            $nature_exp = collect($user['nature_business'])->implode(', ') ?: 'N/A';
            $target_exp = collect($user['target_buyer'])->implode(', ') ?: 'N/A';
            $certifications_exp = collect($user->certification)->pluck('remarks')->implode(', ') ?: 'N/A';

            $export_target_countries = collect([
                optional($exhibitor->country_target_buyer_export_1)->name,
                optional($exhibitor->country_target_buyer_export_2)->name,
                optional($exhibitor->country_target_buyer_export_3)->name,
            ])->filter()->implode(', ') ?: 'N/A';

            $exporting_exp = '';
            if ($exhibitor->industry_rep === 1) {
                $exporting_exp = collect([
                    optional($exhibitor->country_exporting_to_1)->name,
                    optional($exhibitor->country_exporting_to_2)->name,
                    optional($exhibitor->country_exporting_to_3)->name,
                ])->filter()->implode(', ') ?: 'N/A';
            }

            $subcategory_exp = collect($user->category_subcategory ?? [])
                ->pluck('sub_category_remarks')->map(fn($v) => ucwords($v))
                ->implode(', ') ?: 'N/A';

            $arr_char_inputoutput = collect($user->inout ?? [])->pluck('name')->toArray();
            $arr_char_prod_process = collect($user->process ?? [])->pluck('name')->toArray();
            $arr_focus_ranking = collect($user->topic_rank)->pluck('focus_ranking.name')->toArray();
            $arr_topic_picks = collect($user->topic_pick)->pluck('focus_topic.name')->toArray();

            $now = Carbon::now()->format('jS \o\f F, Y');
        
            $data = [
                'cur_date' => $now,
                'user' => $user,
                'exhibitor' => $exhibitor,
                'attendance_info' => $attendance_info,
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
                'topic_picks' => $arr_topic_picks,
                'banner_size' => $exhibitor->banner_size,
                'docs' =>   $documentForFair,
                'cart_items' => $cartItems,
                'additional_fees_items' => $additionalFeesItems,
                'discount_items' => $discountItems,
                'mandatory_fee' => $mandatoryData,
                'addon_items' => $addonItems,  
                'event' => $event,
            ];

            // Generate PDF
            $pdf = PDF::loadView('website.registration.supplier.summary', $data)
                ->setOptions([
                    'isPhpEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true
                ]);

            $pdf->save($fullPath);

            Log::info('PDF generated successfully', ['path' => $fullPath]);
            return $fullPath;

        } else {
            Log::info('generate_pdf currently supports Exhibitors only.', ['user_id' => $user->id]);
            return false;
        }

    } catch (\Throwable $e) {
        Log::error('Error in generate_pdf()', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return false;
    }
}

public function supplier_receive_updates(Request $request, $id)
{
$user = User::findOrFail($id);
$fair_code = $request->input('fair_code');

$exhibitor = $user->exhibitorForFair($fair_code);

if ($exhibitor) {
    $exhibitor->update([
        'received_latest_updates' => $request->boolean('agree'),
    ]);
}

if (env('SSX_API_SYNC')) {
    // $this->citemAPIUpdateExhibitorForfair($user->id, $fair_code);
            $this->citemAPIUpdateExhibitor($user->id );
}

return redirect()->route('supplier.dashboard');
}


public function supplier_registration_thankyou($id, $fair_code)
{
    // Fetch the user (must have status 2)
    $user = User::where('id', $id)
        ->where('status', 1)
        ->firstOrFail();

    // Fetch the related exhibitor record for this fair
    $exhibitor = $user->exhibitorForFair($fair_code);
    if (!$exhibitor) {
        return abort(404, 'Exhibitor record not found for this fair.');
    }

    // Fetch the related event by fair_code
    $event = Event::where('fair_code', $fair_code)->first();
    if (!$event) {
        return abort(404, 'Event not found.');
    }

    // Pass user, exhibitor, and event to the view
    return view('supplier.registration.thankyou', [
        'id' => $user->id,
        'user' => $user,
        'exhibitor' => $exhibitor,
        'event' => $event,
        'fair_code' => $fair_code,
    ]);
}







}
