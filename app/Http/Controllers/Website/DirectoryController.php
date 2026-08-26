<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Cetification;
use App\Models\Supplier\Event;
use Meta;

class DirectoryController extends Controller
{
    public function directories()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'directories')->first();
        
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

        return view('website.solutions.directories.index');
    }

    public function suggest($qry)
    {
        $companies = User::where('user_group', 2)->where('status', 1)->where('name', 'like', '%'.$qry.'%')->get();
        return response()->json($companies, 200);
    }

    public function suppliers()
    {
        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'directories-all')->first();
        
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

        return view('website.solutions.directories.suppliers');
    }

    public function latest_suppliers()
    {
        $latest_suppliers = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
            $query->whereIn('category_id', [1, 2]);
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

    public function latest_solutions()
    {
        //FOOD SOLUTIONS
        $foods = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
            $query->where('category_id', 1);
        })->orderBy('created_at', 'desc')->take(4)->get();
        $arr_foods = [];
        foreach ($foods as $food) {
            if ($food->data_from == 'api') {
                $food_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $food->masthead);
            } else {
                $food_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $food->masthead);
            }
            $food_co_logo = check_file_exist('exhibitors/logos/', 'logo', $food->logo);
            $arr_foods[] = [
                'id' => $food->id,
                'co_name' => $food->exhibitor->co_name,
                'co_details' => Str::limit($food->exhibitor->co_details, 100),
                'slug' => $food->exhibitor->slug,
                'co_logo' => $food_co_logo,
                'co_thumb' => $food_masthead_url,
                'tags' => $food->category_subcategory
            ];
        }

        //LIFESTYLE SOLUTIONS
        $lifestyles = User::where('user_group', 2)->where('status', 1)->whereHas('category_subcategory', function (Builder $query) {
            $query->where('category_id', 2);
        })->orderBy('created_at', 'desc')->take(4)->get();
        $arr_lifestyles = [];
        foreach ($lifestyles as $lifestyle) {
            if ($lifestyle->data_from == 'api') {
                $lifestyle_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $lifestyle->masthead);
            } else {
                $lifestyle_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $lifestyle->masthead);
            }
            $lifestyle_co_logo = check_file_exist('exhibitors/logos/', 'logo', $lifestyle->logo);
            $arr_lifestyles[] = [
                'id' => $lifestyle->id,
                'co_name' => $lifestyle->exhibitor->co_name,
                'co_details' => Str::limit($lifestyle->exhibitor->co_details, 100),
                'slug' => $lifestyle->exhibitor->slug,
                'co_logo' => $lifestyle_co_logo,
                'co_thumb' => $lifestyle_masthead_url,
                'tags' => $lifestyle->category_subcategory
            ];
        }

        $arr_results = [
            'foods' => $arr_foods,
            'lifestyles' => $arr_lifestyles,
        ];

        return response()->json($arr_results, 200);
    }

    // public function list(Request $request)
    // {
    //     $per_page = $request->input('per_page');
    //     $limit = $per_page;
    //     $no_of_records_per_page = $limit;
    //     $page = $request->input('page');
    //     $offset = ($page-1) * $no_of_records_per_page; 

    //     $users = User::where('user_group', 5)->where('status', 1);

    //     if (!empty($request->input('qry'))) {
    //         $qry = $request->input('qry');
    //         $users->whereHas('exhibitor', function (Builder $query) use ($qry) {
    //             $query->where('co_name', 'like', '%'.$qry.'%');
    //         });
    //     }

    //     $arr_categories = json_decode($request->input('categories'), true);
    //     if (!empty($arr_categories)) {
    //         $users->whereHas('category_subcategory', function (Builder $query) use ($arr_categories) {
    //             $query->whereIn('sub_category_id', $arr_categories);
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
    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    // Get latest Event fair_code
    $latestEvent = Event::orderBy('created_at', 'desc')->first();
    $latestFairCode = $latestEvent ? $latestEvent->fair_code : null;

    $users = User::where('user_group', 5)
        ->where('status', 1)
        ->whereHas('exhibitorAttendances', function (Builder $query) use ($latestFairCode) {
            $query->where('fair_code', $latestFairCode)
                  ->where('status', 1);
        });

    // Search query
    if ($request->filled('qry')) {
        $qry = $request->input('qry');
        $users->whereHas('exhibitor', function (Builder $query) use ($qry, $latestFairCode) {
            $query->where('co_name', 'like', '%' . $qry . '%')
                  ->where('fair_code', $latestFairCode);
        });
    }

    // Filter by categories
    $arr_categories = json_decode($request->input('categories'), true);
    if (!empty($arr_categories)) {
        $users->whereHas('category_subcategory', function (Builder $query) use ($arr_categories) {
            $query->whereIn('sub_category_id', $arr_categories);
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

    // Get paginated results
    $res_users = $users->offset($offset)->limit($per_page)->get();

    $arr_users = [];

    foreach ($res_users as $user) {

        // Get exhibitor for the latest fair_code
        $latestExhibitor = $user->exhibitorAttendanceForFair($latestFairCode);

        if (!$latestExhibitor) {
            continue; // skip if no attendance
        }

        // Masthead / Logo
        if ($user->data_from === 'api') {
            $user_masthead_url = check_file_exist('exhibitors/mastheads/', 'thumb', $user->masthead);
        } else {
            $user_masthead_url = check_file_exist('exhibitors/thumbs/', 'thumb', $user->masthead);
        }

        $user_co_logo = check_file_exist('exhibitors/logos/', 'logo', $user->logo);

        $arr_users[] = [
            'id' => $user->id,
            'co_name' => $latestExhibitor->co_name,
            'co_details' => Str::limit($latestExhibitor->co_details, 100),
            'slug' => $latestExhibitor->slug,
            'co_logo' => $user_co_logo,
            'co_thumb' => $user_masthead_url,
            'tags' => $user->category_subcategory,
        ];
    }

    return response()->json([
        'total_rec' => $total,
        'results' => $arr_users,
    ], 200);
}

    // one to one
    // public function details($id, $slug)
    // {
    //     // $user = User::findOrFail($id);
    //     $user = User::where('id', $id)->where('status', 1)->first();

    //     if(!$user){
    //         return redirect()->route('solutions.directories.index');
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

    //     Meta::title($user->exhibitor->co_name);
    //     Meta::set('description', Str::limit($user->exhibitor->co_details, 160));
    //     Meta::set('robots', env('META_ROBOTS'));
    //     Meta::set('image', asset('storage/app/public/exhibitors/logos/'.$user->logo));
    //     Meta::set('canonical', url()->current());

    //     return view('website.solutions.directories.details', compact('user','imp_nature_business','imp_location'));
    // }

   
   
   
   public function details($id, $slug)
{
    $user = User::where('id', $id)->where('status', 1)->first();

    if (!$user) {
        return redirect()->route('solutions.directories.index');
    }

    // Get latest event's fair_code
    $latestEvent = Event::latest('created_at')->first();
    $latestFairCode = $latestEvent ? $latestEvent->fair_code : null;

    // Get latest exhibitor for that fair_code
$exhibitor = $user->exhibitor()->where('fair_code', $latestFairCode)->first();

    if (!$exhibitor) {
        return redirect()->route('solutions.directories.index');
    }

    // Nature of business
    $arr_nature_business = [];
    if ($user->nature_business) {
        foreach ($user->nature_business as $nature_business) {
            $arr_nature_business[] = $nature_business->remarks;
        }
    }
    $imp_nature_business = implode(',', $arr_nature_business);

    // Location
    $arr_location = [
        $exhibitor->moa_street,
        $exhibitor->moa_city,
        $exhibitor->moa_region,
        $exhibitor->main_country ? $exhibitor->main_country->name : '',
        $exhibitor->moa_zipcode
    ];
    $imp_location = implode(' ', $arr_location);

    // Meta
    Meta::title($exhibitor->co_name);
    Meta::set('description', Str::limit($exhibitor->co_details, 160));
    Meta::set('robots', env('META_ROBOTS'));
    Meta::set('image', asset('storage/app/public/exhibitors/logos/'.$user->logo));
    Meta::set('canonical', url()->current());

    return view('website.solutions.directories.details', compact('user','imp_nature_business','imp_location','exhibitor'));
}

// one to one
    // public function product_details($comp_name_slug, $prod_id, $prod_name_slug)
    // {
    //     $product = Product::where('id', $prod_id)->where('slug', '=', $prod_name_slug)->firstOrFail();

    //     $user = User::find($product->uid);

    //     Meta::title($product->name.' - '.$user->exhibitor->co_name);
    //     Meta::set('description', Str::limit($product->description, 160));
    //     Meta::set('robots', env('META_ROBOTS'));
    //     Meta::set('image', asset('storage/app/public/exhibitors/products/'.$product->product_image[0]->image));
    //     Meta::set('canonical', url()->current());

    //     return view('website.solutions.directories.product', compact('product','user'));
    // }

    public function product_details($comp_name_slug, $prod_id, $prod_name_slug)
{
    $product = Product::where('id', $prod_id)
        ->where('slug', $prod_name_slug)
        ->firstOrFail();

    $user = User::findOrFail($product->uid);

    // Get latest event fair_code
    $latestEvent = Event::latest('created_at')->first();
    $latestFairCode = $latestEvent ? $latestEvent->fair_code : null;

    // Get exhibitor for that fair_code
    $exhibitor = $user->exhibitor()
        ->where('fair_code', $latestFairCode)
        ->first();

    if (!$exhibitor) {
        abort(404, "Exhibitor for latest event not found.");
    }

    // Meta
    Meta::title($product->name . ' - ' . $exhibitor->co_name);
    Meta::set('description', Str::limit($product->description, 160));
    Meta::set(
        'image',
        asset('storage/app/public/exhibitors/products/' . $product->product_image[0]->image)
    );
    Meta::set('robots', env('META_ROBOTS'));
    Meta::set('canonical', url()->current());

    return view('website.solutions.directories.product', compact('product', 'user', 'exhibitor'));
}
}
