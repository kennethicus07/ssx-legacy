<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\ContactUs;
use App\Mail\Subscription;

use App\Helpers\EmailHelper;

use App\Models\User;
use App\Models\BannerSize;
use App\Models\Category;
use App\Models\Certification;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\NewsletterSubscription;
use App\Models\EnablerCategories;
use App\Models\Article;
use App\Models\AttendeeType;
use App\Models\Buyer\AnnualPurchaseExistingSupplier;
use App\Models\Buyer\BuyerAttendance;
use App\Models\Buyer\CompanyAnnualSales;
use App\Models\Event;
use App\Models\Supplier\Event as SupplierEvent;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{

    // public function check_company_email_unique($email, $type)
    // {
        
    //     $checkEmailExist = DB::table('users')->where('email', '=', $email);
    //     $checkEmail = $checkEmailExist->exists();
    //     if ($checkEmail) {
    //         $resp = false;
    //     } else {
    //         if (env('SSX_API_SYNC')) {
    //             $resp = $this->citemAPICheckEmailExist($email, $type);
    //         } else {
    //             $resp = true;
    //         }
    //     }                        
    //     return response()->json($resp, 200);
    // }
    
    
    public function check_company_email_unique($email, $type)
{
    // If blank, null, or whitespace, do NOT check
    if (!trim($email)) {
        return response()->json(true, 200);
    }

    // Check in our local database
    $exists = DB::table('users')->where('email', $email)->exists();

    if ($exists) {
        return response()->json(false, 200); // email already used
    }

    // External API check (optional)
    if (env('SSX_API_SYNC')) {
            $resp = $this->citemAPICheckEmailExist($email, $type);
            return response()->json($resp, 200);
        }

    // Email is unique
    return response()->json(true, 200);
}

   public function check_business_name_unique($name, $type)
{
    // If blank, null, or whitespace, treat as OK (don’t check)
    if (!trim($name)) {
        return response()->json(true, 200);
    }

    // Check locally in exhibitors table (recommended)
    $exists = DB::table('users')->where('name', $name)->exists();

    if ($exists) {
        return response()->json(false, 200); // name already used
    }

    // Optional: external API sync
    // if (env('SSX_API_SYNC')) {
    //     $resp = $this->citemAPICheckBusinessNameExist($name, $type);
    //     return response()->json($resp, 200);
    // }

    return response()->json(true, 200);
}



// public function check_company_email_exist($email, $type)
// {
//     // Normalize email
//     $email = Str::lower($email);

//     // Check if email exists in USERS table
//     $checkEmailExist = DB::table('users')->whereRaw('LOWER(email) = ?', [$email]);
//     $emailExists = $checkEmailExist->exists();
//     // Get current event
//     $event = SupplierEvent::latest()->first();
//     $user = $checkEmailExist->first();
//     if ($emailExists) {

//         // Email exists locally → resp = false (like unique method)
//         $resp = false;

//         // Fetch user
//         Log::info('Current event fair_code:', ['fair_code' => $event->fair_code]);
//         // Check if this user already has buyer attendance
//         $buyerAttendance = BuyerAttendance::where('user_id', $user->id)
//             ->where('fair_code', $event->fair_code)
//             ->first();

//         $hasAttendance = $buyerAttendance ? true : false;
//         $attendanceStatus = $buyerAttendance ? $buyerAttendance->status : null;


//         return response()->json([
//             'exists'         => true,
//             'has_attendance' => $hasAttendance,
//             'attendance_status'  => $attendanceStatus, 
//             'user_id'        => $user->id,
//             'resp'           => $resp,
//             'user_group'        => (int) $user->user_group,
            
//             'company_name'   => $user->name,
//             'event_name'         => $event->event_name,
//         ], 200);
//     }

//     // Email does NOT exist locally
//     if (env('SSX_API_SYNC')) {

//         // API result (just like unique method)
//         $resp = $this->citemAPICheckEmailExist($email, $type);

//         return response()->json([
//             'exists'         => $resp ? true : false,
//             'has_attendance' => false,
//             'user_id'        => null,
//             'user_group'     => null, 
//             'resp'           => $resp,     
//             'event_name'     => $event->event_name,
//         ], 200);

//     } else {

//         // No API → resp = true (same as unique method)
//         $resp = true;

//         return response()->json([
//             'exists'         => false,
//             'has_attendance' => false,
//             'user_id'        => null,
//             'resp'           => $resp,
            
//             'event_name'     => $event->event_name,
            
//         ], 200);
//     }
// }


public function check_company_email_exist($email, $type)
{
    $email = Str::lower($email);

    $checkEmailExist = DB::table('users')
        ->whereRaw('LOWER(email) = ?', [$email]);

    $emailExists = $checkEmailExist->exists();
    $event = SupplierEvent::latest()->first();

    if ($emailExists) {

        $user = $checkEmailExist->first();

        $buyerAttendance = BuyerAttendance::where('user_id', $user->id)
            ->where('fair_code', $event->fair_code)
            ->first();

        return response()->json([
            'exists'            => true,
            'has_attendance'    => $buyerAttendance ? true : false,
            'attendance_status' => $buyerAttendance ? $buyerAttendance->status : null,
            'user_id'           => $user->id,
            'user_group'        => (int) $user->user_group,
            'company_name'      => $user->name,
            'event_name'        => $event->event_name,
        ], 200);
    }

    // NOT in local DB → check CITEM API
    if (env('SSX_API_SYNC')) {

        // API returns "is unique"
        $isUnique = $this->citemAPICheckEmailExist($email, $type);

        // Convert meaning
        $exists = !$isUnique;

        return response()->json([
            'exists'            => $exists, 
            'has_attendance'    => false,
            'attendance_status' => null,
            'user_id'           => null,
            'user_group'        => 3, 
            'company_name'      => null,
            'event_name'        => $event->event_name,
        ], 200);
    }

    // No API → allow registration
    return response()->json([
        'exists'            => false,
        'has_attendance'    => false,
        'attendance_status' => null,
        'user_id'           => null,
        'user_group'        => 3,
        'company_name'      => null,
        'event_name'        => $event->event_name,
    ], 200);
}





// public function countries()
// {
//     $countries = DB::table('countries')->whereNotNull('dial')->orderBy('name', 'asc')->get();
//     return response()->json($countries, 200);
// }

public function countries()
{
    $countries = DB::table('countries')
        ->whereNotNull('dial')
        ->orderByRaw("CASE WHEN name = 'Philippines' THEN 0 ELSE 1 END, name ASC")
        ->get();

    return response()->json($countries, 200);
}

    private function getActiveBusinessTypes()
    {
        return DB::table('business_types')
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

      public function active_business_types()
    {
        return response()->json($this->getActiveBusinessTypes(), 200);
    }
    
    public function business_types()
    {
        $results = DB::table('business_types')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function company_sizes()
    {
        $results = DB::table('company_sizes')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function annual_sales_volumes()
    {
        $results = DB::table('annual_sales_volumes')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function organization_types()
    {
        $results = DB::table('organization_types')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function nature_businesses()
    {
        $results = DB::table('nature_businesses')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function certifications()
    {
        // $results = DB::table('certifications')->orderBy('name', 'asc')->get();
        // return response()->json($results, 200);
        $results = Certification::orderBy('name', 'asc')->get();
        return response()->json($results, 200);
    }

    public function honorifics()
{
    $results = DB::table('honorifics')
        ->where('status', 1)
        ->orderBy('id', 'asc')
        ->get();

    return response()->json($results, 200);
}


    public function company_roles()
    {
        $results = DB::table('company_role_purchasing_activities')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function regions()
    {
        $results = DB::table('regions')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function participation_goals()
    {
        $results = DB::table('participation_goals')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function participation_goals_sdg()
    {
        $results = DB::table('participation_goals')
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($results, 200);
    }

    public function learn_about_event()
    {
        $results = DB::table('learn_about_event')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

public function target_buyers()
{
    $results = DB::table('target_buyers')
        ->where('status', 1)
        ->orderBy('id', 'asc')
        ->get();

    return response()->json($results, 200);
}

    public function on_input_output()
    {
        $results = DB::table('on_input_output')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function sdg(){
        $results = DB::table('sdgs')->orderBy('id', 'asc')->get();
        return response()->json($results,200);
    }

    public function on_production_process()
    {
        $results = DB::table('on_production_process')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function rank_topics()
    {
        $results = DB::table('rank_topics')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function banner_sizes()
    {
        $results = BannerSize::orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function article_types()
    {
        $results = DB::table('article_types')->orderBy('id', 'asc')->get();
        return response()->json($results, 200);
    }

    public function exhibitions_conferences()
    {
        $results = DB::table('conferences')->orderBy('conference_date', 'asc')->get();
        return response()->json($results, 200);
    }

    public function categories()
    {
        $categories = Category::all();
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_categories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->sub_categories
            ];
        }
        return response()->json($arr_categories, 200);
    }
    public function categories_pillar()
    {
        $categories = Category::whereNotIn('id', [4, 5])->get();

        $arr_categories = [];

        foreach ($categories as $category) {
            $arr_categories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->sub_categories
            ];
        }

        return response()->json($arr_categories, 200);
    }

    public function categories_is_startup(Request $request)
{
    $isStartup = $request->boolean('is_startup', false);

    // If startup → filter category type = startup
    // Else (default or no param) → type = default
    $type = $isStartup ? 'startup' : 'default';

    $categories = Category::where('type', $type)
        ->with('sub_categories')
        ->get();

    $arr_categories = $categories->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'sub_categories' => $category->sub_categories,
        ];
    });

    return response()->json($arr_categories, 200);
}

 public function categories_group_all()
    {
        $categories = Category::all();
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_categories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->sub_categories
            ];
        }
        return response()->json($arr_categories, 200);
    }

  public function company_annual_sales()
{
    $results = CompanyAnnualSales::orderBy('id', 'asc')->get();

    return response()->json($results, 200);
}

     public function annual_purchase_existing_supplier(){
         $results = AnnualPurchaseExistingSupplier::orderBy('id', 'asc')->get();

    return response()->json($results, 200);
    }

    public function enablers_categories()
    {
        $categories = EnablerCategories::all();
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_categories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'sub_categories' => $category->enabler_sub_categories
            ];
        }
        return response()->json($arr_categories, 200);
    }

    public function delete_document(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        if (!empty($request->input('doc'))) {
            if ($request->input('doc') === 'doc_1') {
                Storage::delete($user->document->dti_sec);
                $user->document()->update([
                    'dti_sec' => NULL
                ]);
            } elseif ($request->input('doc') === 'doc_2') {  
                Storage::delete($user->document->bir);
                $user->document()->update([
                    'bir' => NULL
                ]);
            } elseif ($request->input('doc') === 'doc_3') {
                Storage::delete($user->document->lto);
                $user->document()->update([
                    'lto' => NULL
                ]);
            } elseif ($request->input('doc') === 'doc_4') {
                Storage::delete($user->document->cpr);
                $user->document()->update([
                    'cpr' => NULL
                ]);
            } elseif ($request->input('doc') === 'doc_5') {
                Storage::delete($user->document->other_food_certificate);
                $user->document()->update([
                    'other_food_certificate' => NULL
                ]);
            } elseif ($request->input('doc') === 'doc_6') {
                Storage::delete($user->document->institutional_catalog);
                $user->document()->update([
                    'institutional_catalog' => NULL
                ]);
            } elseif ($request->input('doc') === 'masthead') {
                Storage::delete('/public/exhibitors/mastheads/'.$user->masthead);
                Storage::delete('/public/exhibitors/thumbs/'.$user->masthead);
                $user->masthead = NULL;
            } else {
                Storage::delete('/public/exhibitors/logos/'.$user->logo);
                $user->logo = NULL;
            }
            $user->save();
        }
        return response()->json(true, 200);
    }

    public function delete_product_photo($id)
    {
        $product_img = ProductPhoto::findOrFail($id);
        Storage::delete('/public/exhibitors/products/'.$product_img->image);
        Storage::delete('/public/exhibitors/products/thumbs/'.$product_img->image);
        $product_img->delete();
        return response()->json(true, 200);
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        if (!empty($product->product_images)) {
            foreach ($product->product_images as $image) {
                Storage::delete('/public/exhibitors/products/'.$image->image);
                Storage::delete('/public/exhibitors/products/thumbs/'.$image->image);
            }
            $product->product_images()->delete();
        }
        $product->product_profiles()->delete();
        $product->product_certifications()->delete();
        $product->delete();
        return response()->json(true, 200);
    }

    public function contact_us_store(Request $request)
    {
        $arr_info = [
            'email' => $request->input('email'),
            'fullname' => $request->input('fullname'),
            'company' => $request->input('company'),
            'message' => $request->input('message')
        ];

       if (env('APP_ENV') != 'local') {

        $emails = EmailHelper::parseList(env('INQUIRY_EMAIL'));

    if (!empty($emails)) {
        Mail::to($emails)->send(new ContactUs($arr_info));
    }
} else {
            Mail::to('kgtecson.citem@gmail.com')->send(new ContactUs($arr_info));
        }
        return response()->json(true, 200);
    }

    public function subcription_store(Request $request)
    {
        $email = $request->input('email');
        $newsletter = NewsletterSubscription::where('email', '=', $email)->first();
        if (empty($newsletter->email)) {
            $subscription = new NewsletterSubscription;
            $subscription->email = $email;
            $subscription->save();
            if (env('APP_ENV') != 'local') {
                Mail::to(env('SUBSCRIPTION_EMAIL'))->send(new Subscription($email));
            } else {
                Mail::to('kgtecson.citem@gmail.com')->send(new Subscription($email));
            }
        }
        return response()->json(true, 200);
    }

    public function widgets($id)
    {
        $widget = cache()->rememberForever('widget_'.$id, function () use ($id){
            return DB::table('widgets')->where('status', 1)->where('id', $id)->first();
        });
        return response()->json($widget, 200);
    }

    public function search(Request $request)
    {
        $module = $request->input('module');

        $qry = $request->input('qry');

        $arr_results = [];

        if ($module == 'products') {
            $per_page = $request->input('per_page');
            $limit = $per_page;
            $no_of_records_per_page = $limit;
            $page = $request->input('page');
            $offset = ($page-1) * $no_of_records_per_page; 

            $products = Product::select('id', 'uid', 'name', 'description','slug')->where('name', 'like', '%'.$qry.'%')->where('status', 1);

            $arr_categories = json_decode($request->input('categories'), true);
            if (!empty($arr_categories)) {
                $products->whereHas('product_profiles', function (Builder $query) use ($arr_categories) {
                    $query->whereIn('sub_category_id', $arr_categories);
                });
            }
            
            $total = $products->count();

            if ($request->input('sort') == 1) {
                $products->orderBy('name', 'asc');
            } elseif ($request->input('sort') == 2) {
                $products->orderBy('name', 'desc');
            } elseif ($request->input('sort') == 3) {
                $products->orderBy('created_at', 'desc');
            } else {
                $products->orderBy('created_at', 'asc');
            }

            $res_products = $products->offset($offset)->limit($no_of_records_per_page)->get();

            $arr_products = [];

            foreach ($res_products as $product) {
                //$supplier = DB::table('exhibitors')->where('uid', $product->uid)->first();
                $arr_products[] = [
                    'id' => $product->id,
                    'title' => $product->name,
                    'details' => $product->description,
                    'url' => route('solutions.directories.product_details', [$product->supplier->exhibitor->slug, $product->id, $product->slug]),
                    'thumb' => check_file_exist('exhibitors/products/', 'thumb', $product->product_image[0]->image),
                ];
            }
    
            $arr_results = [
                'total_rec' => $total,
                'results' => $arr_products
            ];
        }

        if ($module == 'suppliers') {
            $per_page = $request->input('per_page');
            $limit = $per_page;
            $no_of_records_per_page = $limit;
            $page = $request->input('page');
            $offset = ($page-1) * $no_of_records_per_page; 

            $suppliers = User::where('name', 'like', '%'.$qry.'%')->where('status', 1)->where('user_group', 2);
            
            $arr_categories = json_decode($request->input('categories'), true);
            if (!empty($arr_categories)) {
                $suppliers->whereHas('category_subcategory', function (Builder $query) use ($arr_categories) {
                    $query->whereIn('sub_category_id', $arr_categories);
                });
            }

            $total = $suppliers->count();

            if ($request->input('sort') == 1) {
                $suppliers->orderBy('name', 'asc');
            } elseif ($request->input('sort') == 2) {
                $suppliers->orderBy('name', 'desc');
            } elseif ($request->input('sort') == 3) {
                $suppliers->orderBy('created_at', 'desc');
            } else {
                $suppliers->orderBy('created_at', 'asc');
            }

            $res_suppliers = $suppliers->offset($offset)->limit($no_of_records_per_page)->get();

            $arr_suppliers = [];

            foreach ($res_suppliers as $supplier) {
                if ($supplier->data_from == 'api') {
                    $thumb = check_file_exist('exhibitors/mastheads/', 'thumb', $supplier->masthead);
                } else {
                    $thumb = check_file_exist('exhibitors/thumbs/', 'thumb', $supplier->masthead);
                }
                $arr_suppliers[] = [
                    'id' => $supplier->id,
                    'title' => $supplier->name,
                    'details' => $supplier->exhibitor->co_details,
                    'url' => route('solutions.directories.details', [$supplier->id, $supplier->exhibitor->slug]),
                    'thumb' => $thumb,
                    'logo' => check_file_exist('exhibitors/logos/', 'logo', $supplier->logo),
                    'tags' => $supplier->category_subcategory
                ];
            }
    
            $arr_results = [
                'total_rec' => $total,
                'results' => $arr_suppliers
            ];
        }

        if ($module == 'articles') {
            $per_page = $request->input('per_page');
            $limit = $per_page;
            $no_of_records_per_page = $limit;
            $page = $request->input('page');
            $offset = ($page-1) * $no_of_records_per_page; 

            $articles = Article::where('status', 1)->where('article_type', '=', 'news-articles')->where('status', 1)->where('title', 'like', '%'.$qry.'%');
            
            $arr_categories = json_decode($request->input('categories'), true);
            if (!empty($arr_categories)) {
                $articles->whereHas('category_tag', function (Builder $query) use ($arr_categories) {
                    $query->whereIn('sub_category_id', $arr_categories);
                });
            }

            $total = $articles->count();

            if ($request->input('sort') == 1) {
                $articles->orderBy('title', 'asc');
            } elseif ($request->input('sort') == 2) {
                $articles->orderBy('title', 'desc');
            } elseif ($request->input('sort') == 3) {
                $articles->orderBy('created_at', 'desc');
            } else {
                $articles->orderBy('created_at', 'asc');
            }

            $res_articles = $articles->offset($offset)->limit($no_of_records_per_page)->get();

            $arr_articles = [];

            foreach ($res_articles as $article) {
                $arr_articles[] = [
                    'id' => $article->id,
                    'title' => $article->title,
                    'details' => Str::limit($article->content, 70).' <a href="'.route('news-articles.details', [$article->slug]).'" class="lightgreen-link">Learn More</a>',
                    'url' => route('news-articles.details', [$article->slug]),
                    'thumb' => check_file_exist('articles/thumbs/', 'thumb', $article->image_thumb),
                ];
            }
    
            $arr_results = [
                'total_rec' => $total,
                'results' => $arr_articles
            ];
        }

        if ($module == 'events') {
            $per_page = $request->input('per_page');
            $limit = $per_page;
            $no_of_records_per_page = $limit;
            $page = $request->input('page');
            $offset = ($page-1) * $no_of_records_per_page; 

            $events = Event::where('status', 1)->where('status', 1)->where('title', 'like', '%'.$qry.'%');
            
            $arr_categories = json_decode($request->input('categories'), true);
            if (!empty($arr_categories)) {
                $events->whereHas('category_tag', function (Builder $query) use ($arr_categories) {
                    $query->whereIn('sub_category_id', $arr_categories);
                });
            }

            $total = $events->count();

            if ($request->input('sort') == 1) {
                $events->orderBy('title', 'asc');
            } elseif ($request->input('sort') == 2) {
                $events->orderBy('title', 'desc');
            } elseif ($request->input('sort') == 3) {
                $events->orderBy('created_at', 'desc');
            } else {
                $events->orderBy('created_at', 'asc');
            }

            $res_events = $events->offset($offset)->limit($no_of_records_per_page)->get();

            $arr_events = [];

            foreach ($res_events as $event) {
                $arr_events[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'link' => $event->event_link,
                    'type' => $event->event_type,
                    'platform' => $event->platform,
                    'location' => $event->location,
                    'organizer' => $event->organizer,
                    'thumb' => check_file_exist('events/thumbs/', 'thumb', $event->event_banner),
                    'logo' => check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo),
                ];
            }
    
            $arr_results = [
                'total_rec' => $total,
                'results' => $arr_events
            ];
        }

        return response()->json($arr_results, 200);
    }


    //! Attendee Type

        public function attendeeTypes(Request $request)
    {
        $types = AttendeeType::where('status', 1)->orderBy('name')->get();
        return response()->json($types, 200);
    }
}
