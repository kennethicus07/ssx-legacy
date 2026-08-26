<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\User;
use Meta;

class SustainableSolutionsController extends Controller
{
    public function index()
    {
        $seconds = 86400; //1 Day
        
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'sustainable-solutions')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        if (!empty($meta->meta_author)) {
            Meta::set('author', $meta_tag->meta_author);
        }
        if (!empty($meta->meta_image)) {
            Meta::set('image', asset('storage/app/public/meta_images/'.$meta->meta_image));
        }
        Meta::set('canonical', url()->current());

        return view('website.solutions.sustainable.index');
    }

    public function search($qry)
    {
        $sustainable = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
            $query->where('category_id', 3);
        })->where('name', 'like', '%'.$qry.'%')->get();

        return response()->json($sustainable, 200);
    }

    public function suppliers()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'sustainable-all')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        if (!empty($meta->meta_author)) {
            Meta::set('author', $meta_tag->meta_author);
        }
        if (!empty($meta->meta_image)) {
            Meta::set('image', asset('storage/app/public/meta_images/'.$meta->meta_image));
        }
        Meta::set('canonical', url()->current());

        return view('website.solutions.sustainable.suppliers');
    }

    public function latest_suppliers()
    {
        $latest_suppliers = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
            $query->where('category_id', 3);
        })->orderBy('created_at', 'desc')->take(10)->get();
        $arr_results = [];
        foreach ($latest_suppliers as $latest) {
            if ($latest->data_from == 'api') {
                $masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $latest->masthead);
            } else {
                $masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $latest->masthead);
            }
            $co_logo = check_file_exist('exhibitors/logos/', 'logo', $latest->logo);
            $arr_results[] = [
                'id' => $latest->id,
                'co_name' => $latest->exhibitor->co_name,
                'co_details' => Str::limit($latest->exhibitor->co_details, 100),
                'slug' => $latest->exhibitor->slug,
                'co_logo' => $co_logo,
                'co_thumb' => $masthead_url,
                'tags' => $latest->category_subcategory
            ];
        }
        return response()->json($arr_results, 200);
    }

    public function advance_latest_suppliers()
    {
        //ADVANCE SOLUTIONS
        $advances = User::where('user_group', 2)->where('status', 1)->where('solution_type', '=', 'sustainable')->whereHas('category_subcategory', function (Builder $query) {
            $query->where('category_id', 3);
        })->orderBy('created_at', 'desc')->take(4)->get();
        $arr_advances = [];
        foreach ($advances as $advance) {
            if ($advance->data_from == 'api') {
                $advance_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $advance->masthead);
            } else {
                $advance_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $advance->masthead);
            }
            $advance_co_logo = check_file_exist('exhibitors/logos/', 'logo', $advance->logo);
            $arr_advances[] = [
                'id' => $advance->id,
                'co_name' => $advance->exhibitor->co_name,
                'co_details' => Str::limit($advance->exhibitor->co_details, 100),
                'slug' => $advance->exhibitor->slug,
                'co_logo' => $advance_co_logo,
                'co_thumb' => $advance_masthead_url,
                'tags' => $advance->category_subcategory
            ];
        }

        $arr_results = [
            'advance' => $arr_advances,
        ];

        return response()->json($arr_results, 200);
    }


    //one to one
    // public function list(Request $request)
    // {
    //     $per_page = $request->input('per_page');
    //     $limit = $per_page;
    //     $no_of_records_per_page = $limit;
    //     $page = $request->input('page');
    //     $offset = ($page-1) * $no_of_records_per_page; 

    //     $users = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
    //         $query->where('category_id', 3);
    //     });

    //     if (!empty($request->input('qry'))) {
    //         $qry = $request->input('qry');
    //         $users->whereHas('exhibitor', function (Builder $query) use ($qry) {
    //             $query->where('co_name', 'like', '%'.$qry.'%');
    //         });
    //     }

    //     $total = $users->count();

    //     if ($request->input('sort') == 1) {
    //         $users->orderBy('name', 'asc');
    //     } elseif ($request->input('sort') == 2) {
    //         $users->orderBy('name', 'desc');
    //     } elseif ($request->input('sort') == 3) {
    //         $users->orderBy('created_at', 'desc');
    //     } else {
    //         $users->orderBy('created_at', 'asc');
    //     }

    //     $res_users = $users->offset($offset)->limit($no_of_records_per_page)->get();

    //     $arr_users = [];
        
    //     foreach ($res_users as $user) {
    //         if ($user->data_from == 'api') {
    //             $user_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $user->masthead);
    //         } else {
    //             $user_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $user->masthead);
    //         }
    //         $user_co_logo = check_file_exist('exhibitors/logos/', 'logo', $user->logo);
    //         $arr_users[] = [
    //             'id' => $user->id,
    //             'co_name' => $user->exhibitor->co_name,
    //             'co_details' => Str::limit($user->exhibitor->co_details, 100),
    //             'slug' => $user->exhibitor->slug,
    //             'co_logo' => $user_co_logo,
    //             'co_thumb' => $user_masthead_url,
    //             'tags' => $user->category_subcategory
    //         ];
    //     }

    //     $arr_results = [
    //         'total_rec' => $total,
    //         'results' => $arr_users
    //     ];

    //     return response()->json($arr_results, 200);
    // }
    

public function list(Request $request)
{
    // Get the latest event fair_code
    $latestEvent = Event::orderBy('created_at', 'desc')->first();
    $latestFairCode = $latestEvent ? $latestEvent->fair_code : null;

    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $users = User::where('user_group', 5)
        ->where('status', 1)
        ->whereHas('category_subcategory', function (Builder $query) {
            $query->where('status', 1);
        })
        ->whereHas('exhibitor', function (Builder $q) use ($latestFairCode) {
            if ($latestFairCode) {
                $q->where('fair_code', $latestFairCode);
            }
        })
        // --- Only users with exhibitor_attendance for latest fair and status = 1 ---
        ->whereHas('exhibitorAttendances', function (Builder $q) use ($latestFairCode) {
            $q->where('fair_code', $latestFairCode)
              ->where('status', 1);
        });

    // Search filter
    if (!empty($request->input('qry'))) {
        $qry = $request->input('qry');
        $users->whereHas('exhibitor', function (Builder $query) use ($qry, $latestFairCode) {
            $query->where('co_name', 'like', '%'.$qry.'%')
                  ->where('fair_code', $latestFairCode);
        });
    }

    // Count total before pagination
    $total = $users->count();

    // Sorting
    $sort = $request->input('sort');
    if ($sort == 1) {
        $users->orderBy('name', 'asc');
    } elseif ($sort == 2) {
        $users->orderBy('name', 'desc');
    } elseif ($sort == 3) {
        $users->orderBy('created_at', 'desc');
    } else {
        $users->orderBy('created_at', 'asc');
    }

    // Fetch users with pagination
    $res_users = $users->offset($offset)->limit($per_page)->get();

    $arr_users = [];

    foreach ($res_users as $user) {

        // --- GET USER EXHIBITOR FOR LATEST FAIR CODE ---
        $exhibitor = $user->exhibitorAttendanceForFair($latestFairCode);

        if (!$exhibitor) {
            continue; // Skip users without attendance for this fair
        }

        // Masthead / Logo
        if ($user->data_from == 'api') {
            $user_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $user->masthead);
        } else {
            $user_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $user->masthead);
        }

        $user_co_logo = check_file_exist('exhibitors/logos/', 'logo', $user->logo);

        $arr_users[] = [
            'id' => $user->id,
            'co_name'    => $exhibitor->co_name,
            'co_details' => Str::limit($exhibitor->co_details, 100),
            'slug'       => $exhibitor->slug,
            'co_logo'    => $user_co_logo,
            'co_thumb'   => $user_masthead_url,
            'tags'       => $user->category_subcategory
        ];
    }

    return response()->json([
        'total_rec' => $total,
        'results'   => $arr_users
    ], 200);
}

    // one to one
    // public function details($id, $slug)
    // {
    //     // $user = User::findOrFail($id);
    //     $user = User::where('id', $id)->where('status', 1)->first();

    //     if(!$user){
    //         return redirect()->route('solutions.sustainable.index');
    //     }

    //     $arr_nature_business = [];
    //     if (!empty($user->nature_business)) {
    //         foreach ($user->nature_business as $nature_business) {
    //             $arr_nature_business[] = $nature_business->remarks;
    //         }
    //     }
    //     $imp_nature_business = implode(',', $arr_nature_business);

    //     $arr_location = [];
    //     $arr_location[] = $user->exhibitor->moa_street;
    //     $arr_location[] = $user->exhibitor->moa_city;
    //     $arr_location[] = $user->exhibitor->moa_region;
    //     $arr_location[] = $user->exhibitor->main_country->name;
    //     $arr_location[] = $user->exhibitor->moa_zipcode;
    //     $imp_location = implode(' ', $arr_location);

    //     return view('website.solutions.sustainable.details', compact('user','imp_nature_business','imp_location'));
    // }

    public function details($id, $slug)
{
    // Get user
    $user = User::where('id', $id)->where('status', 1)->first();
    if (!$user) {
        return redirect()->route('solutions.sustainable.index');
    }

    // Get latest event's fair_code
    $latestEvent = \App\Models\Supplier\Event::orderBy('fair_code', 'desc')->first();
    $latestFairCode = $latestEvent ? $latestEvent->fair_code : null;

    // Load the exhibitor for latest fair
    $exhibitor = $latestFairCode ? $user->exhibitorForFair($latestFairCode) : null;
    if (!$exhibitor) {
        return redirect()->route('solutions.sustainable.index');
    }

    // Nature business
    $arr_nature_business = [];
    if (!empty($user->nature_business)) {
        foreach ($user->nature_business as $nature_business) {
            $arr_nature_business[] = $nature_business->remarks;
        }
    }
    $imp_nature_business = implode(',', $arr_nature_business);

    // Location
    $arr_location = [];
    $arr_location[] = $exhibitor->moa_street;
    $arr_location[] = $exhibitor->moa_city;
    $arr_location[] = $exhibitor->moa_region;
    $arr_location[] = $exhibitor->main_country->name ?? '';
    $arr_location[] = $exhibitor->moa_zipcode;
    $imp_location = implode(' ', $arr_location);

    return view('website.solutions.sustainable.details', compact('user','imp_nature_business','imp_location','exhibitor'));
}

}
