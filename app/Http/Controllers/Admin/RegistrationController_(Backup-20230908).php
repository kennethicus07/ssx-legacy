<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Mail\ExhibitorEmailRegistrationValidation;
use App\Mail\BuyerEmailRegistrationValidation;
use App\Mail\ApprovedApplication;
use App\Mail\DeniedApplication;
use App\Mail\OnHoldApplication;
use App\Models\Certification;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\NatureBusiness;
use App\Models\TargetBuyer;
use App\Models\AboutEvent;
use App\Models\ParticipationGoal;
use Carbon\Carbon;
use Image;

class RegistrationController extends Controller
{
    public function suppliers()
    {
        return view('admin.registration.supplier.index');
    }

    public function buyers()
    {
        return view('admin.registration.buyer.index');
    }

    public function list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $users = User::where('user_group', 2);

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['co_name'])) {
                $users->whereHas('exhibitor', function (Builder $query) use ($filters) {
                    $query->where('co_name', 'like', '%'.$filters['co_name'].'%');
                });
            }
            if (!empty($filters['co_email'])) {
                $users->whereHas('exhibitor', function (Builder $query) use ($filters) {
                    $query->where('co_email', '=', $filters['co_email']);
                });
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'incomplete') {
                    $users->where('status', 0);
                } else {
                    $users->where('status', $filters['status']);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            if ($sort['field'] == 'co_name' || $sort['field'] == 'co_email') {
                $users->with(['exhibitor' => function ($query) use ($sort) {
                    $query->orderBy("{$sort['field']}", "{$sort['type']}");
                }]);
            } else {
                $users->orderBy("{$sort['field']}", "{$sort['type']}");
            }
        }

        $total_users = $users->count();

        $records = $users->offset($offset)->limit($no_of_records_per_page)->get();

        foreach ($records as $supplier) {
            $supplier->exhibitor;
            $supplier->exhibitor->approver;
            $supplier->exhibitor->reviewer;
            $supplier->exhibitor->disapprover;
            $supplier->exhibitor->onholder;
        }

        $arr_permissions = [
            'can_view' => Auth::user()->can('view reg_suppliers'),
            'can_resend' => Auth::user()->can('resend reg_suppliers'),
            'can_approved' => Auth::user()->can('approve reg_suppliers'),
            'can_review' => Auth::user()->can('review reg_suppliers'),
            'can_hold' => Auth::user()->can('onhold reg_suppliers'),
            'can_deny' => Auth::user()->can('disapprove reg_suppliers'),
            'can_edit' => Auth::user()->can('edit reg_suppliers'),
            'can_add' => Auth::user()->can('add reg_suppliers')
        ];

        return response()->json(['total' => $total_users, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    public function buyers_list(Request $request)
    {
        $per_page = $request->input('per_page');
        $limit = $per_page;
        $no_of_records_per_page = $limit;
        $page = $request->input('page');
        $offset = ($page-1) * $no_of_records_per_page; 

        $users = User::where('user_group', 3);

        if ($request->has('filter')) {
            $filters = json_decode($request->input('filter'), true);
            if (!empty($filters['co_name'])) {
                $users->whereHas('buyer', function (Builder $query) use ($filters) {
                    $query->where('co_name', 'like', '%'.$filters['co_name'].'%');
                });
            }
            if (!empty($filters['co_email'])) {
                $users->whereHas('buyer', function (Builder $query) use ($filters) {
                    $query->where('co_email', '=', $filters['co_email']);
                });
            }
            if (!empty($filters['country'])) {
                $users->whereHas('buyer', function (Builder $query) use ($filters) {
                    $query->where('country', $filters['country']);
                });
            }
            if (!empty($filters['status'])) {
                if ($filters['status'] == 'incomplete') {
                    $users->where('status', 0);
                } else {
                    $users->where('status', $filters['status']);
                }
            }
        }

        if ($request->has('sort')) {
            $sort = json_decode($request->input('sort'), true);
            if ($sort['field'] == 'co_name' || $sort['field'] == 'co_email' || $sort['field'] == 'country') {
                $users->with(['buyer' => function ($query) use ($sort) {
                    $query->orderBy("{$sort['field']}", "{$sort['type']}");
                }]);
            } else {
                $users->orderBy("{$sort['field']}", "{$sort['type']}");
            }
        }

        $total_users = $users->count();

        $records = $users->offset($offset)->limit($no_of_records_per_page)->get();
       
        foreach ($records as $buyer) {
            $buyer->buyer;
            $buyer->buyer->b_country;
            $buyer->buyer->approver;
            $buyer->buyer->reviewer;
            $buyer->buyer->disapprover;
            $buyer->buyer->onholder;
        }

        $arr_permissions = [
            'can_view' => Auth::user()->can('view reg_buyers'),
            'can_resend' => Auth::user()->can('resend reg_buyers'),
            'can_approved' => Auth::user()->can('approve reg_buyers'),
            'can_review' => Auth::user()->can('review reg_buyers'),
            'can_hold' => Auth::user()->can('onhold reg_buyers'),
            'can_deny' => Auth::user()->can('disapprove reg_buyers'),
            'can_add' => Auth::user()->can('add reg_purchaser'),
            'can_edit' => Auth::user()->can('edit reg_purchaser'),
        ];

        return response()->json(['total' => $total_users, 'data' => $records, 'permissions' => $arr_permissions], 200);
    }

    public function supplier_create()
    {
        return view('admin.registration.supplier.create');
    }

    public function view($id)
    {
        return view('admin.registration.supplier.view', ['id' => $id]);
    }

    public function buyer_view($id)
    {
        return view('admin.registration.buyer.view', ['id' => $id]);
    }

    public function resend_registation_link($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            if (env('APP_ENV') != 'local') {
                Mail::to(strtolower($user->email))->send(new ExhibitorEmailRegistrationValidation($user->id));
            } else {
                Mail::to('wendevette@gmail.com')->send(new ExhibitorEmailRegistrationValidation($user->id));
            }
        } else {
            //BUYER
            if (env('APP_ENV') != 'local') {
                Mail::to(strtolower($request->input('ref_email')))->send(new BuyerEmailRegistrationValidation($user->id));
            } else {
                Mail::to('wendevette@gmail.com')->send(new BuyerEmailRegistrationValidation($user->id));
            }
        }
        return response()->json(true, 200);
    }

    public function review($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            $user->exhibitor()->update([
                'reviewed_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
            $user->status = 3;
            $user->save();
        } else {
            //BUYER
            $user->buyer()->update([
                'reviewed_by' => Auth::id(),
                'last_update_by' => Auth::id()
            ]);
            $user->status = 3;
            $user->save();
        }

        if (env('SSX_API_SYNC')) {
            $this->citemAPIValidateStatus($user->email, 'reviewed', $user->user_group);
        }

        return response()->json(true, 200);
    }

    public function revert_to_inc($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            $user->exhibitor()->update([
                'reviewed_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
            $user->status = 0;
            $user->save();
        } 
        // else {
        //     //BUYER
        //     $user->buyer()->update([
        //         'reviewed_by' => Auth::id(),
        //         'last_update_by' => Auth::id()
        //     ]);
        //     $user->status = 3;
        //     $user->save();
        // }

        if (env('SSX_API_SYNC')) {
            $this->citemAPIValidateStatus($user->email, 'reviewed', $user->user_group);
        }

        return response()->json(true, 200);
    }

    public function supplier_update(Request $request)
    {
        $user = User::where('id', $request->input('user_id'))->firstOrFail();

        $company_info = json_decode($request->input('company_info'), true);
        $contact_info = json_decode($request->input('contact_info'), true);
        $business_info = json_decode($request->input('business_info'), true);
        $order_info = json_decode($request->input('order_info'), true);

        $status = $request->input('status');
        if ($status) {
            $user->status = 2;
        }
        
        $destinationPath = storage_path('app/public/exhibitors/');

        if ($request->hasFile('company_masthead')) {
            $masthead = $request->file('company_masthead');
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
        if ($request->hasFile('company_logo')) {
            $logo = $request->file('company_logo');
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
        $user->save();



        $arr_country_exporting_to = [];
        if (!empty($business_info['country_exporting_to'])) {
            foreach ($business_info['country_exporting_to'] as $country_exporting_to_key => $country_exporting_to_value) {
                $arr_country_exporting_to['ir_country_exporting_'.($country_exporting_to_key+1)] = $country_exporting_to_value['id'];
            }
        }


        $arr_target_countries = [];
        if (!empty($business_info['target_countries_export'])) {
            foreach ($business_info['target_countries_export'] as $target_countries_export_key => $target_countries_export_value) {
                $arr_target_countries['target_country_export_'.($target_countries_export_key+1)] = $target_countries_export_value['id'];
            }
        }


        $arr_supplier_info = [
            'co_name' => Str::upper($company_info['co_name']),
            'slug' => Str::of($company_info['co_name'])->slug('-'),
            'directory_name' => Str::title($company_info['directory_name']),
            'co_details' => $company_info['co_profile'],
            'mission_statement' => $company_info['mission'],
            'env_conservation' => $company_info['env_conservation'],
            'phone_country_code' => $company_info['phone_country_code'],
            'phone_area_code' => $company_info['phone_area_code'],
            'phone_no' => $company_info['phone_no'],
            'mobile_country_code' => $company_info['mobile_country_code'],
            'mobile_no' => $company_info['mobile_no'],
            'website' => $company_info['website'],
            'facebook' => $company_info['facebook'],
            'twitter' => $company_info['twitter'],
            'instagram' => $company_info['instagram'],
            'linkedin' => $company_info['linkedin'],
            'other_social' => $company_info['other_social'],
            'fa_country' => $company_info['fa_country'],
            'fa_state' => $company_info['fa_state'],
            'fa_city' => $company_info['fa_city'],
            'fa_zipcode' => $company_info['fa_zipcode'],
            'fa_region' => $company_info['fa_region'],
            'fa_street' => $company_info['fa_street'],
            'moa_country' => $company_info['moa_country'],
            'moa_state' => $company_info['moa_state'],
            'moa_city' => $company_info['moa_city'],
            'moa_zipcode' => $company_info['moa_zipcode'],
            'moa_region' => $company_info['moa_region'],
            'moa_street' => $company_info['moa_street'],
            'business_type_id' => $business_info['business_type'],
            'company_size_id' => $business_info['company_size'],
            'annual_sales_volume_id' => $business_info['annual_sales_volume'] ? $business_info['annual_sales_volume'] : NULL,
            'direct_workers' => $business_info['direct_workers'],
            'indirect_workers' => $business_info['indirect_workers'],
            'organization_type_id' => $business_info['organization_type'],
            'industry_rep' => $business_info['industry_rep'] ? $business_info['industry_rep'] : NULL,
            'product_promoted' => $business_info['product_promoted'],
            'banner_size_id' => $order_info['banner_size'],
            'updated_by' => Auth::id()
        ];


        $arr_supplier_info_merge = array_merge($arr_supplier_info,  $arr_country_exporting_to, $arr_target_countries);
        //print_r($arr_supplier_info_merge); exit;
        $user->exhibitor()->update($arr_supplier_info_merge);

        

        $user->products()->update([
            'status' => 1
        ]);

        //NATURE BUSINESS
        if (!empty($user->nature_business)) {
            $user->nature_business()->delete();
        }
        $arr_nature_business = [];
        foreach ($business_info['nature_business'] as $nb) {
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
        foreach ($business_info['target_buyers'] as $target) {
            $target_buyer = TargetBuyer::find($target);
            if (!empty($target_buyer)) {
                if ($target_buyer->id === 6) {
                    $remarks = Str::title($business_info['target_buyer_others']);
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
        foreach ($business_info['certifications'] as $cert) {
            $certification = Certification::find($cert);
            if (!empty($certification)) {
                if ($certification->id === 14) {
                    $remarks = Str::title($business_info['certification_others']);
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
        foreach ($business_info['categories'] as $sub) {
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
        foreach ($business_info['on_input_output'] as $input_output) {
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
        foreach ($business_info['production_process'] as $pprocess) {
            if ($pprocess === 3) {
                $pp_remarks = Str::title($business_info['production_process_others']);
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
        foreach ($business_info['topic_rank'] as $rank_key => $rank) {
            if ($rank_key >= 1) {
                $arr_topic_rank[] = [
                    'topic_id' => $rank_key,
                    'rank' => $rank
                ];
            }
        }
        $user->topic_rank()->createMany($arr_topic_rank);

        $user->business_owner()->updateOrCreate(
            [
                'uid' => $user->id
            ],
            [
                'fname' => Str::title($contact_info['business_owner']['fname']),
                'lname' => Str::title($contact_info['business_owner']['lname']),
                'mi' => Str::upper($contact_info['business_owner']['mi']),
                'designation' => $contact_info['business_owner']['designation'],
                'email' => str::lower($contact_info['business_owner']['email']),
                'country_code' => $contact_info['business_owner']['country_code'],
                'mobile_no' => $contact_info['business_owner']['mobile_no']
            ]
        );



        $user->business_contact_person()->updateOrCreate(
            [
                'uid' => $user->id
            ],
            [
                'fname' => Str::title($contact_info['business_contact_person']['fname']),
                'lname' => Str::title($contact_info['business_contact_person']['lname']),
                'mi' => Str::upper($contact_info['business_contact_person']['mi']),
                'designation' => $contact_info['business_contact_person']['designation'],
                'email' => str::lower($contact_info['business_contact_person']['email']),
                'country_code' => $contact_info['business_contact_person']['country_code'],
                'mobile_no' => $contact_info['business_contact_person']['mobile_no']
            ]
        );


        if ($request->hasFile('doc1')) {
            $doc1 = $request->file('doc1')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc1 = $user->document->dti_sec;
            } else {
                $doc1 = NULL;
            } 
        }
        if ($request->hasFile('doc2')) {
            $doc2 = $request->file('doc2')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc2 = $user->document->bir;
            } else {
                $doc2 = NULL;
            }
        }
        if ($request->hasFile('doc3')) {
            $doc3 = $request->file('doc3')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc3 = $user->document->lto;
            } else {
                $doc3 = NULL;
            }
        }
        if ($request->hasFile('doc4')) {
            $doc4 = $request->file('doc4')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc4 = $user->document->cpr;
            } else {
                $doc4 = NULL;
            }
        }
        if ($request->hasFile('doc5')) {
            $doc5 = $request->file('doc5')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc5 = $user->document->other_food_certificatecpr;
            } else {
                $doc5 = NULL;
            }
        }
        if ($request->hasFile('doc6')) {
            $doc6 = $request->file('doc6')->store('public/documents', 'local');
        } else {
            if (!empty($user->document)) {
                $doc6 = $user->document->institutional_catalog;
            } else {
                $doc6 = NULL;
            }
        }

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

        // if (env('SSX_API_SYNC')) {
        //     $this->citemAPIUpdateExhibitor($user->id);
        //     if ($status) {
                // $this->citemAPIValidateStatus($user->email, $status, $user->user_group);
        //     }
        // }
        // $this->generate_pdf($user->id);
        return response()->json(true, 200);

// HOLDHOLDHOLD
    }

    // public function supplier_store(Request $request)
    // {
    //     $company_info = json_decode($request->input('company_info'), true);
    //     $contact_info = json_decode($request->input('contact_info'), true);
    //     $business_info = json_decode($request->input('business_info'), true);
    //     $order_info = json_decode($request->input('order_info'), true);

    //     $status = $request->input('status');

    //     $user = new User;
    //     $user->name = Str::upper($company_info['co_name']);
    //     $user->email = Str::of($company_info['co_email'])->lower();
    //     $user->password = NULL;
    //     $user->user_group = 2;
    //     $user->data_from = 'backend';
    //     if ($status) {
    //         $user->status = 2;
    //     }

    //     switch ($request->input('status')) {
    //         case 0:
    //             $user->reg_token = sha1(time());
    //         break;
    //         case 1:
    //             $user->reg_token = sha1(time());
    //         break;
    //         case 2:
    //             $user->reg_token = sha1(time());
    //         break;
    //         case 4:
    //             $user->reg_token = NULL;
    //         break;
    //         case 5:
    //             $user->reg_token = NULL;
    //         break;
    //         default:
    //             $user->reg_token = sha1(time());
    //         break;
    //     }

    //     $destinationPath = storage_path('app/public/exhibitors/');

    //     if ($request->hasFile('company_masthead')) {
    //         $masthead = $request->file('company_masthead');
    //         if ($masthead) {
    //             $filename_masthead = md5(time()).'.'.$masthead->clientExtension();
    //             $resize_masthead = Image::make($masthead);
    //             $resize_masthead->fit(1920, 400, function ($constraint) {
    //                 $constraint->upsize();
    //             });
    //             $resize_masthead->save($destinationPath.'/mastheads/'.$filename_masthead, 70);
    //             $resize_masthead->fit(290, 160, function ($constraint) {
    //                 $constraint->upsize();
    //             });
    //             $resize_masthead->save($destinationPath.'/thumbs/'.$filename_masthead, 70);
    //             $user->masthead = $filename_masthead;
    //         }
    //     }
    //     if ($request->hasFile('company_logo')) {
    //         $logo = $request->file('company_logo');
    //         if ($logo) {
    //             $filename_logo = md5(time()).'.'.$logo->clientExtension();
    //             $logo_canvas = Image::canvas(156, 156);
    //             $resize_logo = Image::make($logo);
    //             $resize_logo->resize(155, 155, function ($constraint) {
    //                 $constraint->aspectRatio();
    //                 $constraint->upsize();
    //             });
    //             $logo_canvas->insert($resize_logo, 'center');
    //             $logo_canvas->save($destinationPath.'/logos/'.$filename_logo, 70);
    //             $user->logo = $filename_logo;
    //         }
    //     }
    //     $user->save();

    //     $arr_country_exporting_to = [];
    //     if (!empty($business_info['country_exporting_to'])) {
    //         foreach ($business_info['country_exporting_to'] as $country_exporting_to_key => $country_exporting_to_value) {
    //             $arr_country_exporting_to['ir_country_exporting_'.($country_exporting_to_key+1)] = $country_exporting_to_value['id'];
    //         }
    //     }
    //     $arr_target_countries = [];
    //     if (!empty($business_info['target_countries_export'])) {
    //         foreach ($business_info['target_countries_export'] as $target_countries_export_key => $target_countries_export_value) {
    //             $arr_target_countries['target_country_export_'.($target_countries_export_key+1)] = $target_countries_export_value['id'];
    //         }
    //     }

    //     $arr_supplier_info = [
    //         'co_name' => Str::upper($company_info['co_name']),
    //         'slug' => Str::of($company_info['co_name'])->slug('-'),
    //         'co_email' => Str::of($company_info['co_email'])->lower(),
    //         'directory_name' => Str::title($company_info['directory_name']),
    //         'co_details' => $company_info['co_profile'],
    //         'mission_statement' => $company_info['mission'],
    //         'env_conservation' => $company_info['env_conservation'],
    //         'phone_country_code' => $company_info['phone_country_code'],
    //         'phone_area_code' => $company_info['phone_area_code'],
    //         'phone_no' => $company_info['phone_no'],
    //         'mobile_country_code' => $company_info['mobile_country_code'],
    //         'mobile_no' => $company_info['mobile_no'],
    //         'website' => $company_info['website'],
    //         'facebook' => $company_info['facebook'],
    //         'twitter' => $company_info['twitter'],
    //         'instagram' => $company_info['instagram'],
    //         'linkedin' => $company_info['linkedin'],
    //         'other_social' => $company_info['linkedin'],
    //         'fa_same_as_moa' => $company_info['same_as_moa'],
    //         'fa_country' => $company_info['fa_country'],
    //         'fa_state' => $company_info['fa_state'],
    //         'fa_city' => $company_info['fa_city'],
    //         'fa_zipcode' => $company_info['fa_zipcode'],
    //         'fa_region' => $company_info['fa_region'],
    //         'fa_street' => $company_info['fa_street'],
    //         'moa_country' => $company_info['moa_country'],
    //         'moa_state' => $company_info['moa_state'],
    //         'moa_city' => $company_info['moa_city'],
    //         'moa_zipcode' => $company_info['moa_zipcode'],
    //         'moa_region' => $company_info['moa_region'],
    //         'moa_street' => $company_info['moa_street'],
    //         'business_type_id' => $business_info['business_type'],
    //         'company_size_id' => $business_info['company_size'],
    //         'annual_sales_volume_id' => $business_info['annual_sales_volume'] ? $business_info['annual_sales_volume'] : NULL,
    //         'direct_workers' => $business_info['direct_workers'],
    //         'indirect_workers' => $business_info['indirect_workers'],
    //         'organization_type_id' => $business_info['organization_type'],
    //         'industry_rep' => $business_info['industry_rep'] ? $business_info['industry_rep'] : NULL,
    //         'product_promoted' => $business_info['product_promoted'],
    //         'banner_size_id' => $order_info['banner_size'],
    //         'added_by' => Auth::id()
    //     ];

    //     $arr_supplier_info_merge = array_merge($arr_supplier_info,  $arr_country_exporting_to, $arr_target_countries);
    //     //print_r($arr_supplier_info_merge); exit;
    //     $user->exhibitor()->create($arr_supplier_info_merge);

    //     //NATURE BUSINESS
    //     $arr_nature_business = [];
    //     foreach ($business_info['nature_business'] as $nb) {
    //         $nature_business = NatureBusiness::find($nb);
    //         if (!empty($nature_business)) {
    //             $arr_nature_business[] = [
    //                 'nature_business_id' => $nature_business->id,
    //                 'remarks' => $nature_business->name
    //             ];
    //         }
    //     }
    //     $user->nature_business()->createMany($arr_nature_business);

    //     //TARGET BUYERS
    //     $arr_target_buyers = [];
    //     foreach ($business_info['target_buyers'] as $target) {
    //         $target_buyer = TargetBuyer::find($target);
    //         if (!empty($target_buyer)) {
    //             if ($target_buyer->id === 6) {
    //                 $remarks = Str::title($business_info['target_buyer_others']);
    //             } else {
    //                 $remarks = $target_buyer->name;
    //             }
    //             $arr_target_buyers[] = [
    //                 'target_buyer_id' => $target_buyer->id,
    //                 'remarks' => $remarks
    //             ];
    //         }
    //     }
    //     $user->target_buyer()->createMany($arr_target_buyers);

    //     //CERTIFICATIONS
    //     $arr_certifications = [];
    //     foreach ($business_info['certifications'] as $cert) {
    //         $certification = Certification::find($cert);
    //         if (!empty($certification)) {
    //             if ($certification->id === 14) {
    //                 $remarks = Str::title($business_info['certification_others']);
    //             } else {
    //                 $remarks = $certification->name;
    //             }
    //             $arr_certifications[] = [
    //                 'certification_id' => $certification->id,
    //                 'remarks' => $remarks
    //             ];
    //         }
    //     }
    //     $user->certification()->createMany($arr_certifications);

    //     //Categories & Sub-Categories
    //     $arr_categories = [];
    //     foreach ($business_info['categories'] as $sub) {
    //         $sub_category = SubCategory::find($sub);
    //         if (!empty($sub_category)) {
    //             $arr_categories[] = [
    //                 'category_id' => $sub_category->category_id,
    //                 'category_remarks' => $sub_category->category->name,
    //                 'sub_category_id' => $sub_category->id,
    //                 'sub_category_remarks' => $sub_category->name
    //             ];
    //         }
    //     }
    //     $user->category_subcategory()->createMany($arr_categories);

    //     //On Input / Output
    //     $arr_input_ouput = [];
    //     foreach ($business_info['on_input_output'] as $input_output) {
    //         $arr_input_ouput[] = [
    //             'input_output_id' => $input_output
    //         ];
    //     }
    //     $user->on_input_output()->createMany($arr_input_ouput);

    //     //On Production Process
    //     $arr_production_process = [];
    //     foreach ($business_info['production_process'] as $pprocess) {
    //         if ($pprocess === 3) {
    //             $pp_remarks = Str::title($business_info['production_process_others']);
    //         } else {
    //             $pp_remarks = NULL;
    //         }
    //         $arr_production_process[] = [
    //             'production_process_id' => $pprocess,
    //             'other_certification' => $pp_remarks
    //         ];
    //     }
    //     $user->on_production_process()->createMany($arr_production_process);

    //     //TOPIC RANGKING
    //     $arr_topic_rank = [];
    //     foreach ($business_info['topic_rank'] as $rank_key => $rank) {
    //         if ($rank_key >= 1) {
    //             $arr_topic_rank[] = [
    //                 'topic_id' => $rank_key,
    //                 'rank' => $rank
    //             ];
    //         }
    //     }
    //     $user->topic_rank()->createMany($arr_topic_rank);

    //     $user->business_owner()->updateOrCreate(
    //         [
    //             'uid' => $user->id
    //         ],
    //         [
    //             'fname' => Str::title($contact_info['business_owner']['fname']),
    //             'lname' => Str::title($contact_info['business_owner']['lname']),
    //             'mi' => Str::upper($contact_info['business_owner']['mi']),
    //             'designation' => $contact_info['business_owner']['designation'],
    //             'email' => str::lower($contact_info['business_owner']['email']),
    //             'country_code' => $contact_info['business_owner']['country_code'],
    //             'mobile_no' => $contact_info['business_owner']['mobile_no']
    //         ]
    //     );
    //     $user->business_contact_person()->updateOrCreate(
    //         [
    //             'uid' => $user->id
    //         ],
    //         [
    //             'fname' => Str::title($contact_info['business_contact_person']['fname']),
    //             'lname' => Str::title($contact_info['business_contact_person']['lname']),
    //             'mi' => Str::upper($contact_info['business_contact_person']['mi']),
    //             'designation' => $contact_info['business_contact_person']['designation'],
    //             'email' => str::lower($contact_info['business_contact_person']['email']),
    //             'country_code' => $contact_info['business_contact_person']['country_code'],
    //             'mobile_no' => $contact_info['business_contact_person']['mobile_no'],
    //             'same_as_bo' => $contact_info['business_contact_person']['same_as_bo']
    //         ]
    //     );

    //     if (env('SSX_API_SYNC')) {
    //         $this->citemAPICreate($user->id);
    //     }
    //     //$this->generate_pdf($user->id);
    //     return response()->json(true, 200);
    // }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            $user->exhibitor()->update([
                'approved_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
            $user->reg_token = sha1(time());
            $user->solution_type = 'marketplace';
            $user->status = 1;
            $user->save();
        } else {
            //BUYER
            $user->buyer()->update([
                'approved_by' => Auth::id(),
                'last_update_by' => Auth::id()
            ]);
            $user->reg_token = sha1(time());
            $user->status = 1;
            $user->save();
        }
        if (env('SSX_API_SYNC')) {
            $this->citemAPIValidateStatus($user->email, 'approved', $user->user_group);
        }
        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($user->email))->send(new ApprovedApplication($user->id));
        } else {
            Mail::to('wendevette@gmail.com')->send(new ApprovedApplication($user->id));
        }

        return response()->json(true, 200);
    }

    public function deny($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            $user->exhibitor()->update([
                'disapproved_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
            $user->reg_token = NULL;
            $user->status = 5;
            $user->solution_type = NULL;
            $user->save();
        } else {
            //BUYER
            $user->buyer()->update([
                'disapproved_by' => Auth::id(),
                'last_update_by' => Auth::id()
            ]);
            $user->reg_token = NULL;
            $user->status = 5;
            $user->save();
        }
        if (env('SSX_API_SYNC')) {
            $this->citemAPIValidateStatus($user->email, 'disapproved', $user->user_group);
        }
        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($user->email))->send(new DeniedApplication($user->id));
        } else {
            Mail::to('wendevette@gmail.com')->send(new DeniedApplication($user->id));
        }
        return response()->json(true, 200);
    }

    public function onhold($id)
    {
        $user = User::findOrFail($id);
        if ($user->user_group === 2) {
            //SUPPLIER
            $user->exhibitor()->update([
                'onhold_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
            $user->reg_token = NULL;
            $user->status = 4;
            $user->solution_type = NULL;
            $user->save();
            
            if (env('APP_ENV') != 'local') {
                Mail::to(strtolower($user->email))->send(new OnHoldApplication($user->id));
            } else {
                Mail::to('wendevette@gmail.com')->send(new OnHoldApplication($user->id));
            }
        } else {
            //BUYER
            $user->buyer()->update([
                'onhold_by' => Auth::id(),
                'last_update_by' => Auth::id()
            ]);
            $user->reg_token = NULL;
            $user->status = 4;
            $user->save();
        }

        if (env('SSX_API_SYNC')) {
            $this->citemAPIValidateStatus($user->email, 'waitlisted', $user->user_group);
        }

        return response()->json(true, 200);
    }

    public function supplier_product_store(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));

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

        return response()->json(true, 200);
    }

    public function purchaser_create(Request $request)
    {
        return view('admin.registration.buyer.create');
    }

    public function purchaser_store(Request $request)
    {
        $company_info = json_decode($request->input('company_info'), true);
        $purchaser_profile = json_decode($request->input('buyer_profile'), true);
        $participation_info = json_decode($request->input('participation_info'), true);

        $status = $request->input('set_to_pending');

        $user = new User;
        $user->name = Str::upper($company_info['co_name']);
        $user->email = Str::of($company_info['email'])->lower();
        $user->password = NULL;
        $user->user_group = 3;
        $user->data_from = 'backend';
        if ($status) {
            $user->status = 2;
        }
        $user->save();

        $user->buyer()->create([
            'country' => $company_info['country'],
            'co_name' => Str::upper($company_info['co_name']),
            'slug' => Str::of($company_info['co_name'])->slug('-'),
            'co_email' => Str::lower($company_info['co_email']),
            'state' => $company_info['fa_state'],
            'city' => $company_info['fa_city'],
            'zipcode' => $company_info['fa_zipcode'],
            'region' => $company_info['fa_region'],
            'street' => $company_info['fa_street'],
            'country_code' => $company_info['country_code'],
            'area_code' => $company_info['area_code'],
            'phone_no' => $company_info['phone_no'],
            'website' => $company_info['website'],
            'year_established' => $company_info['year_estab'],
            'facebook' => $company_info['facebook'],
            'instagram' => $company_info['instagram'],
            'linkedin' => $company_info['linkedin'],
            'other_social' => $company_info['other_social'],
            'organization_type_id' => $company_info['organization_type'],
            'honorific' => $company_info['honorific'],
            'fname' => Str::title($company_info['fname']),
            'lname' => Str::title($company_info['lname']),
            'mi' => Str::upper($company_info['mi']),
            'email' => Str::of($company_info['email'])->lower(),
            'designation' => Str::title($company_info['designation']),
            'company_role_id' => $company_info['role'],
            'interested_meeting' => $participation_info['interested'],
            'need_interpreter' => ($participation_info['interested'] == 1) ? $participation_info['if_yes'] : NULL,
            'last_update_by' => Auth::id()
        ]);

        //NATURE BUSINESS
        if (!empty($user->nature_business)) {
            $user->nature_business()->delete();
        }
        $arr_nature_business = [];
        foreach ($company_info['nature_business'] as $nb) {
            $nature_business = NatureBusiness::find($nb);
            if (!empty($nature_business)) {
                $arr_nature_business[] = [
                    'nature_business_id' => $nature_business->id,
                    'remarks' => $nature_business->name
                ];
            }
        }
        $user->nature_business()->createMany($arr_nature_business);

        //Categories & Sub-Categories
        if (!empty($user->category_subcategory)) {
            $user->category_subcategory()->delete();
        }
        $arr_categories = [];
        foreach ($purchaser_profile['categories'] as $sub) {
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

        //PARTICIPATION GOALS
        if (!empty($user->participation_goal)) {
            $user->participation_goal()->delete();
        }
        $arr_participation_goal = [];
        foreach ($participation_info['participation_goals'] as $goal) {
            $participation_goal = ParticipationGoal::find($goal);
            if (!empty($participation_goal)) {
                if ($participation_goal->id === 11) {
                    $remarks = Str::title($participation_info['participation_goal_others']);
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

        //HOW DID YOU LEARN ABOUT THE EVENT
        if (!empty($user->learn_about_event)) {
            $user->learn_about_event()->delete();
        }
        $arr_learn_about_event = [];
        foreach ($participation_info['about_events'] as $event) {
            $about_event = AboutEvent::find($event);
            if (!empty($about_event)) {
                if ($about_event->id === 9) {
                    $remarks = Str::title($participation_info['about_event_others']);
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

        // if (env('SSX_API_SYNC')) {
        //     $this->citemAPICreate($user->id);
        // }

        return response()->json(true, 200);
    }

    public function purchaser_update(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::findOrFail($user_id);

        $status = $request->input('set_to_pending');

        $user->name = Str::upper($request->input('co_name'));
        if ($status) {
            $user->status = 2;
        }
        $user->save();

        $company_info = json_decode($request->input('company_info'), true);
        $purchaser_profile = json_decode($request->input('buyer_profile'), true);
        $participation_info = json_decode($request->input('participation_info'), true);

        $user->buyer()->update([
            'country' => $company_info['country'],
            'co_name' => Str::upper($company_info['co_name']),
            'co_email' => Str::lower($company_info['co_email']),
            'state' => $company_info['fa_state'],
            'city' => $company_info['fa_city'],
            'zipcode' => $company_info['fa_zipcode'],
            'region' => $company_info['fa_region'],
            'street' => $company_info['fa_street'],
            'country_code' => $company_info['country_code'],
            'area_code' => $company_info['area_code'],
            'phone_no' => $company_info['phone_no'],
            'website' => $company_info['website'],
            'year_established' => $company_info['year_estab'],
            'facebook' => $company_info['facebook'],
            'instagram' => $company_info['instagram'],
            'linkedin' => $company_info['linkedin'],
            'other_social' => $company_info['other_social'],
            'organization_type_id' => $company_info['organization_type'],
            'honorific' => $company_info['honorific'],
            'fname' => Str::title($company_info['fname']),
            'lname' => Str::title($company_info['lname']),
            'mi' => Str::upper($company_info['mi']),
            'designation' => Str::title($company_info['designation']),
            'company_role_id' => $company_info['role'],
            'interested_meeting' => $participation_info['interested'],
            'need_interpreter' => ($participation_info['interested'] == 1) ? $participation_info['if_yes'] : NULL,
            'last_update_by' => Auth::id()
        ]);
        //NATURE BUSINESS
        if (!empty($user->nature_business)) {
            $user->nature_business()->delete();
        }
        $arr_nature_business = [];
        foreach ($company_info['nature_business'] as $nb) {
            $nature_business = NatureBusiness::find($nb);
            if (!empty($nature_business)) {
                $arr_nature_business[] = [
                    'nature_business_id' => $nature_business->id,
                    'remarks' => $nature_business->name
                ];
            }
        }
        $user->nature_business()->createMany($arr_nature_business);

        //Categories & Sub-Categories
        if (!empty($user->category_subcategory)) {
            $user->category_subcategory()->delete();
        }
        $arr_categories = [];
        foreach ($purchaser_profile['categories'] as $sub) {
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

        //PARTICIPATION GOALS
        if (!empty($user->participation_goal)) {
            $user->participation_goal()->delete();
        }
        $arr_participation_goal = [];
        foreach ($participation_info['participation_goals'] as $goal) {
            $participation_goal = ParticipationGoal::find($goal);
            if (!empty($participation_goal)) {
                if ($participation_goal->id === 11) {
                    $remarks = Str::title($participation_info['participation_goal_others']);
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

        //HOW DID YOU LEARN ABOUT THE EVENT
        if (!empty($user->learn_about_event)) {
            $user->learn_about_event()->delete();
        }
        $arr_learn_about_event = [];
        foreach ($participation_info['about_events'] as $event) {
            $about_event = AboutEvent::find($event);
            if (!empty($about_event)) {
                if ($about_event->id === 9) {
                    $remarks = Str::title($participation_info['about_event_others']);
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

        if (env('SSX_API_SYNC')) {
            $this->citemAPIUpdateBuyer($user->id);
        }

        return response()->json(true, 200);
    }
}
