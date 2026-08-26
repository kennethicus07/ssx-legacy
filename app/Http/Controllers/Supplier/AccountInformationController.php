<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\NatureBusiness;
use App\Models\SubCategory;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\TargetBuyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AccountInformationController extends Controller
{

    public function view()
    {
        $user = Auth::guard('supplier')->user();
    
    $tabs = ['company_info', 'product_info', 'contact_info', 'business_info', 'order_info', 'docs_requirements'];
    $actions = ['view', 'save','edit'];
    $tabPermissions = [];

    foreach ($tabs as $tab) {
        foreach ($actions as $action) {
            $tabPermissions[$tab][$action] = $user->can('supplier-tab-action', [$tab, $action]);
        }
    }

        return view('supplier.dashboard.view', [
            'id' => $user->id,
             'tab_permissions' => $tabPermissions, 
        ]);
    }

    public function account_info_store(Request $request){

    $user = User::findOrFail($request->input('user_id'));
$authUserId = Auth::guard('web')->user() 
          ?: Auth::guard('supplier')->user();

    $event_fair_code = $request->input('event_fair_code');
  $attendance = $user->exhibitorAttendanceForFair($event_fair_code);

if ($request->input('step') == 1) {
    // STEP 1: Logo, Masthead, Exhibitor info
    $step1_decode = json_decode($request->input('step1_data'), true);
    // Server-side validation to prevent overly long/payloads
    $validator = Validator::make($step1_decode, [
        'directory_name' => 'required|string|max:100',
        'co_details' => 'required|string|max:2000',
        'mission' => 'required|string|max:1000',
        'env_conservation' => 'nullable|string|max:1000',
        'country_code' => 'required',
        'area_code' => 'required|string|max:5',
        'phone_no' => 'required|string|max:12',
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
    //     $this->citemAPIUpdateExhibitorForfair($user->id, $event_fair_code);
    // }
    } elseif ($request->input('step') == 'add_product') {
        $prod_info = json_decode($request->input('prod_info'), true);

        // Validate product inputs
        $prodValidator = Validator::make($prod_info, [
            'prod_name' => 'required|string|max:95',
            'prod_details' => 'nullable|string|max:2000',
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
            'fname' => 'required|string|max:95',
            'lname' => 'required|string|max:95',
            'mi' => 'nullable|string|max:4',
            'designation' => 'required|string|max:95',
            'email' => 'required|email|max:145',
            'country_code_mobile_bo' => 'required',
            'mobile_no_bo' => 'required|string|max:15',
            'bcp_fname' => 'required|string|max:95',
            'bcp_lname' => 'required|string|max:95',
            'bcp_mi' =>  'nullable|string|max:4',
            'bcp_designation' => 'required|string|max:95',
            'bcp_email' => 'required|email|max:145',
            'bcp_country_code' => 'required',
            'bcp_mobile_no' => 'required|string|max:12',
        ],[], [
        'fname' => 'First Name',
        'lname' => 'Last Name',
        'mi' => 'Middle Initial',
        'designation' => 'Designation',
        'email' => 'Email',
        'country_code_mobile_bo' => 'Mobile Country Code',
        'mobile_no_bo' => 'Mobile Number',
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

        $user->exhibitor()->update([
    'updated_at' => now(),
]);
        
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateExhibitorForFair($user->id, $event_fair_code);
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

        'input_ouput' => 'required|array',
        'production_process' => 'required|array',
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
       
       
    ]
);
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
->unique(fn($item) => $item['fair_code'] . '-' . $item['production_process_id']) // ✅ Avoid duplicates
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

// if (env('SSX_API_SYNC')) {
    // $this->citemAPIUpdateExhibitorForFair($user->id,$event_fair_code);
// }

Log::info('Step 3 processing finished', ['user_id' => $user->id]);
 return response()->json([
        'business_type' => $exhibitor->business_type_id,
        'start_up' => $exhibitor->start_up,
    ], 200);
    } elseif ($request->input('step') == 4) {
            $step4_decode = json_decode($request->input('step4_data'), true);
            $user->exhibitor()->update([
                'banner_size_id' => $step4_decode['banner_size']
            ]);
            // if (env('SSX_API_SYNC')) {
            //     $this->citemAPIUpdateExhibitorForFair($user->id, $event_fair_code);
            // }
        } else {
// FINAL STEP: Handle Documents
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



// Scope exhibitor by fair_code (just like in Step 1 & Step 3)
$exhibitor = $user->exhibitorForFair($event_fair_code);
$businessType = optional($exhibitor)->business_type_id;

$docRules = [];
foreach ($docFields as $input => $column) {
    $docRules[$input] = 'nullable|mimes:pdf,jpg,jpeg,png|max:1024';
}

$docValidator = Validator::make($request->all(), $docRules);
if ($docValidator->fails()) {
    return response()->json(['errors' => $docValidator->errors()], 422);
}

    // Fetch existing documents for this fair_code
    $existingDocs = $user->exhibitorDocumentFor($event_fair_code)->first();
$docs = [];


foreach ($docFields as $input => $column) {
    $currentValue = optional($user->document)->{$column};

    if ($request->hasFile($input)) {
        // Delete old file if exists
        if ($currentValue && Storage::exists($currentValue)) {
            Storage::delete($currentValue);
        }
        // Save new file
        $path = $request->file($input)->store('public/documents', 'local');
        $docs[$column] = $path;
    } else {
        // Keep old file if nothing uploaded
        $docs[$column] = $currentValue;
    }
}


$type3 = ['dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate'];
$type1and2 = ['business_certification', 'food_or_environmental_certification'];

// Force local doc fields to null depending on business type
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


// $user->exhibitorAttendances()->updateOrCreate(
//     ['fair_code' => $event_fair_code], 
//     ['status' => 2]             
// );



// ✅ SAFER version: only update new uploads, preserve existing docs
$existingDocs = $user->exhibitorDocumentFor($event_fair_code)->first();

if ($existingDocs) {
    // Update only the new docs (don’t erase old ones)
    foreach ($docs as $key => $value) {
        if (!empty($value)) {
            $existingDocs->{$key} = $value;
        }
    }
    $existingDocs->save();
} else {
    // Create if doesn’t exist
    $user->document()->create(array_merge(
        ['uid' => $user->id, 'fair_code' => $event_fair_code],
        $docs
    ));
}

      $user->exhibitor()->update([
    'updated_at' => now(),
]);
// Save agreement info in exhibitor_attendance
// $data = [];

// if ($request->filled('registration_agreement_id')) {
//     $data['registration_agreement_id'] = $request->input('registration_agreement_id');
//     $data['registration_agreement_status'] = 1;
//     $data['registration_agreement_agreed_at'] = now();
// }

// if ($request->filled('privacy_policy_id')) {
//     $data['privacy_policy_id'] = $request->input('privacy_policy_id');
//     $data['privacy_policy_status'] = 1;
//     $data['privacy_policy_agreed_at'] = now();
// }

// Only update if there’s at least one agreement
// if (!empty($data)) {
//     ExhibitorAttendance::updateOrCreate(
//         [
//             'user_id'   => $user->id,
//             'fair_code' => $event_fair_code,
//         ],
//         $data
//     );
// }




}

return response()->json(true, 200);
    }

    public function index(){
        return view('supplier.user_accounts.changepassword');
    }

       public function update(Request $request)
    {
       $authUser = Auth::guard('supplier')->user();
       $user_id = $authUser->id;

        if (!empty($user_id)) {
            $user = User::findOrFail($user_id);

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                'new_password_confirmation' => 'required|min:8'
            ]);

            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
                $user->password_unhash = $request->input('new_password');
                $user->save();
                
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login');
            } else {
                $errors = ['current_password' => 'The provided password does not match our records.'];
                return redirect()->back()->withErrors($errors);
            }
        }
    }
}


