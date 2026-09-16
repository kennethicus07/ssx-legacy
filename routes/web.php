<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\ArticleController;
use App\Http\Controllers\Website\EventController;
use App\Http\Controllers\Website\OnDemandResourceController;
use App\Http\Controllers\Website\SustainableSolutionsController;
use App\Http\Controllers\Website\SolutionsIntelligenceController;
use App\Http\Controllers\Website\RegistrationController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\DirectoryController;
use App\Http\Controllers\Website\CertificationController;
use App\Http\Controllers\Website\ExportEnablerController;
use App\Http\Controllers\Website\ConferenceController;
use App\Http\Controllers\Website\DelegateConferenceController;
use App\Http\Controllers\Website\PagesController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ConformeController;
use App\Http\Controllers\Website\BuyerController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Imports\CompanySustainable;
use App\Imports\CompanyMarketplace;
use App\Imports\CompanyBanner;
use Maatwebsite\Excel\Facades\Excel;

// SUPPLIER REGISTRATION CONTROLLER; 
use App\Http\Controllers\Supplier\RegistrationSupplierController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('email/plain-text', function(){
    Mail::raw('This is a sample mail.', function($message) {
       $message->from('mac.calidguid@reprisedigital.com', 'Mac Devette');
       $message->to('use-swam@vfcmkadv.mailosaur.net');
       $message->subject('Mail Test');
    });  
    dd('Send Email Successfully');
});

// Route::get('/oeifhncioea/test-237cy4br3xr31xrn', [TestController::class, 'testSend']);

Route::get('/generate-password', function() {
    return Hash::make('12345678');
});

Route::get('/test-api/reg', function() {
    $url = env('SSX_API_URL').'/proj_buyers?limit=5&offset=10';
    $response = Http::withHeaders([
        'x-api-key' => env('SSX_API_KEY')
    ])->get($url);
    return $result = $response->object();
    // if ($result->status == 'success') {
    //     foreach ($result->data as $data) {
    //         print_r($data->target_countries);
    //     }
    // }
});

Route::get('/clean-fb-url', function() {
    $facebook = DB::table('exhibitors')->get();
    foreach ($facebook as $fb) {
        $url_parse = parse_url($fb->facebook);
        echo '<pre>';
        print_r($url_parse);
    }
});

Route::get('/import-suppliers-sustainable', function() {
    Excel::import(new CompanySustainable, 'assets/import/supplier_sustainable.xlsx');
    return 'done';
    // $dir = 'assets/SSXAssetsforwebsite';
    // if ($handle = opendir($dir)) {
    //     while (false !== ($fileName = readdir($handle))) {
    //$newName = str_replace("SKU#","",$fileName);
    //         $newName = preg_replace('/\s+/', '', strtolower($fileName));
    //         @rename($dir.'/'.$fileName, $dir.'/'.$newName);
    //     }
    //     closedir($handle);
    // }
});

Route::get('/import-suppliers-marketplace', function() {
    Excel::import(new CompanyMarketplace, 'assets/import/supplier_marketplace.xlsx');
    return 'done';
});

Route::get('/import-suppliers-banner', function() {
    Excel::import(new CompanyBanner, 'assets/import/supplier_banners.xlsx');
    return 'done';
});

Route::get('/fixed-facebook-url', function() {
    $facebook = DB::table('exhibitors')->whereNotNull('facebook')->get();
    foreach ($facebook as $fb) {
        $arr_replace = ['www.faceboook.com','facebook.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.facebook.com/','https://facebook.com/','www.facebook.com/','https://m.facebook.com/','m.facebook.com/','http://fb.com/','fb.com/','https://web.facebook.com/','web.facebook.com/','/'];
        $clean_url = str_replace($arr_replace, "", $fb->facebook);
        if (!empty($clean_url)) {
            DB::table('exhibitors')->where('id', $fb->id)->update(['facebook' => $clean_url]);
        }
    }
});

Route::get('/fixed-instagram-url', function() {
    $instagram = DB::table('exhibitors')->whereNotNull('instagram')->get();
    foreach ($instagram as $ig) {
        $arr_replace = ['www.instagram.com','instagram.com','http:','https:','N/A','n/a','www.','Www.','Http:','https://www.instagram.com/','https://instagram.com/','www.instagram.com/','https://m.instagram.com/','m.instagram.com/','https://web.instagram.com/','web.instagram.com/','INSTAGRAM.com','/'];
        $clean_url = str_replace($arr_replace, "", $ig->instagram);
        if (!empty($clean_url)) {
            DB::table('exhibitors')->where('id', $ig->id)->update(['instagram' => $clean_url]);
        }
    }
});

Route::get('/import-suppliers/{token}', function($token) {
    if ($token == 'f25a2fc72690b780b2a14e140ef6a9e0') {
        Artisan::call('upload:exhibitors');
    }
});

Route::get('/import-purchasers/{token}', function($token) {
    if ($token == 'f25a2fc72690b780b2a14e140ef6a9e0') {
        Artisan::call('upload:buyers');
    }
});

Route::middleware(['guest:web,supplier'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.attempt');
    Route::post('/popup/login', [AuthController::class, 'loginvue']);
    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('auth.forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password_request'])->name('auth.forgot.password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])->name('auth.reset.password');
    Route::post('/reset-password', [AuthController::class, 'reset_password_attempt'])->name('auth.reset.password.attempt');
    Route::get('/registration/{group}/{token}/authentication', [AuthController::class, 'authentication'])->name('registration.authentication');
    Route::post('/registration/{group}/{token}/authentication', [AuthController::class, 'create_authentication'])->name('registration.authentication.create');
    Route::get('/registration/{group}/authentication/thank-you', [AuthController::class, 'thankyou_authentication'])->name('registration.authentication.thankyou');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/on-demand-resources/{slug}', [OnDemandResourceController::class, 'details'])->name('on-demand-resources.details');

    Route::post('logout', function(Request $request) {
        activity('logged-out')
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->log('logged-out');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

Route::get('/events', [EventController::class, 'index'])->name('events-activities.index');
// Route::get('/events/show-info', [EventController::class, 'showInfo'])->name('events-activities.showInfo');

Route::get('/events/show-info', [EventController::class, 'conference_and_exhibition'])->name('events-activities.conference_and_exhibition');

Route::get('/events/sponsor', [EventController::class, 'sponsor'])->name('events-activities.sponsor');

Route::get('events/sustainable-development-goals-asia-2025',[EventController::class, 'sdg2025'])->name('events-activities.sdg_asia_2025');

Route::get('events/sustainable-development-goals-asia-2026',[EventController::class, 'sdg2026'])->name('events-activities.sdg_asia_2026');

// Route::get('events/ssx-conference-and-exhibition',[EventController::class, 'conference_and_exhibition'])->name('events-activities.conference_and_exhibition');

Route::post('/on-demand-resources/list', [OnDemandResourceController::class, 'on_demand_resources_list']);

Route::get('/sitemap', [HomeController::class, 'sitemap'])->name('sitemap');

Route::get('sitemap.xml', [HomeController::class, 'sitemap_xml'])->name('sitemap.xml');

Route::get('/service-redirect', [HomeController::class, 'serviceRedirect'])->name('serviceRedirect');

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');
Route::get('/news-articles', [ArticleController::class, 'index'])->name('news-articles.index');
Route::post('/news-articles/more', [ArticleController::class, 'more_news_articles'])->name('news-articles.list');
Route::get('/news-articles/{slug}', [ArticleController::class, 'details'])->name('news-articles.details');

Route::get('/services/business-solutions-services', [ExportEnablerController::class, 'index'])->name('services.export-enablers.index');
Route::get('/services/business-solutions-services/search/{qry}', [ExportEnablerController::class, 'search'])->name('services.export-enablers.search');
Route::post('/services/business-solutions-services/list', [ExportEnablerController::class, 'list'])->name('services.export-enablers.list');
Route::get('/services/business-solutions-services/featured_partners', [ExportEnablerController::class, 'featured_partners'])->name('services.export-enablers.featured_partners');
Route::get('/services/business-solutions-services/about', [ExportEnablerController::class, 'about'])->name('services.export-enablers.about');
Route::get('/services/business-solutions-services/programs_offers', [ExportEnablerController::class, 'programs_offers'])->name('services.export-enablers.programs_offers');
Route::get('/services/business-solutions-services/programs-offers/{id}/{slug}', [ExportEnablerController::class, 'programs_offers_details'])->name('services.export-enablers.programs_offers_details');

Route::get('/certifications', [CertificationController::class, 'index'])->name('certifications.index');
Route::get('/certifications/search/{qry}', [CertificationController::class, 'search'])->name('certifications.search');
Route::post('/certifications/list', [CertificationController::class, 'list'])->name('certifications.list');

Route::middleware('guest:web,supplier')->group(function(){
Route::get('/registration/supplier', [RegistrationController::class, 'supplier_intro'])->name('registration.supplier.intro');
Route::get('/registration/supplier/email-validation', [RegistrationController::class, 'supplier'])->name('registration.supplier');
// Route::post('/registration/supplier/email-validation', [RegistrationController::class, 'supplier_email_validation'])->name('registration.supplier.email.validation');
Route::post('/registration/supplier/email-validation', [RegistrationSupplierController::class, 'supplier_email_validation'])->name('registration.supplier.email.validation');
// Route::get('/registration/supplier/{token}', [RegistrationController::class, 'supplier_registration'])->name('registration.supplier.steps');
Route::post('/registration/supplier/store', [RegistrationController::class, 'supplier_store'])->name('registration.supplier.store');
Route::get('/registration/supplier/{token}/thank-you', [RegistrationController::class, 'supplier_registration_thankyou'])->name('registration.supplier.thankyou');
Route::put('/registration/supplier/recieve-updates/{id}', [RegistrationController::class, 'supplier_receive_updates'])->name('registration.supplier.recieve.updates');
Route::get('/registration/purchaser', [RegistrationController::class, 'buyer_intro'])->name('registration.buyer.intro');
Route::get('/registration/purchaser/email-validation', [RegistrationController::class, 'buyer'])->name('registration.buyer');

Route::post('/registration/purchaser/email-validation', [RegistrationController::class, 'buyer_email_validation'])->name('registration.buyer.email.validation');
Route::get('/registration/purchaser/{token}', [RegistrationController::class, 'buyer_registration'])->name('registration.buyer.steps')->middleware('signed','no.cache'); 
Route::get('/registration/purchaser/{token}/thank-you', [RegistrationController::class, 'buyer_registration_thankyou'])->name('registration.buyer.thankyou');
Route::post('/registration/purchaser/store', [RegistrationController::class, 'buyer_store'])->name('registration.buyer.store');
});


//! CONFERENCE DELEGATE REGISTRATION

Route::get('/conference/registration', [DelegateConferenceController::class, 'registrationForm'])->name('conference.registration');
Route::get('/conference/rates', [DelegateConferenceController::class, 'getConferenceRates'])->name('conference.rates');
Route::post('/conference/registration/code', [DelegateConferenceController::class, 'checkConferenceCode'])->name('conference.registration.checkCode');
Route::post('/conference/registration/participant/add', [DelegateConferenceController::class, 'storeConferenceParticipant'])->name('conference.registration.participant.add');
Route::post('/conference/registration/participant/delete', [DelegateConferenceController::class, 'deleteConferenceParticipant'])->name('conference.registration.participant.delete');
Route::post('/conference/registration/compute', [DelegateConferenceController::class, 'computeConference'])->name('conference.registration.compute');
Route::post('/conference/registration/store', [DelegateConferenceController::class, 'storeConferenceRegistration'])->name('conference.registration.store');


Route::prefix('solutions')->name('solutions.')->group(function () {
    Route::get('/marketplace', [DirectoryController::class, 'directories'])->name('directories.index');
    Route::get('/marketplace/suggest/{qry}', [DirectoryController::class, 'suggest'])->name('directories.suggest');
    Route::get('/marketplace/suppliers', [DirectoryController::class, 'suppliers'])->name('directories.suppliers');
    Route::post('/marketplace/suppliers/list', [DirectoryController::class, 'list'])->name('directories.list');
    Route::get('/marketplace/{id}/{slug}', [DirectoryController::class, 'details'])->name('directories.details');
    Route::get('/marketplace/product/{company}/{prod_id}/{prod_slug}', [DirectoryController::class, 'product_details'])->name('directories.product_details');
    Route::get('/latest-suppliers', [DirectoryController::class, 'latest_suppliers'])->name('directories.latest.suppliers');
    Route::get('/latest-solutions', [DirectoryController::class, 'latest_solutions'])->name('directories.solutions.suppliers');

    Route::get('/sustainable', [SustainableSolutionsController::class, 'index'])->name('sustainable.index');
    Route::get('/sustainable/suppliers', [SustainableSolutionsController::class, 'suppliers'])->name('sustainable.suppliers');
    Route::get('/sustainable/latest-suppliers', [SustainableSolutionsController::class, 'latest_suppliers'])->name('sustainable.latest.suppliers');
    Route::get('/sustainable/latest-advance-suppliers', [SustainableSolutionsController::class, 'advance_latest_suppliers'])->name('sustainable.latest.advance.suppliers');
    Route::get('/sustainable/search/{qry}', [SustainableSolutionsController::class, 'search'])->name('sustainable-solutions.search');
    Route::post('/sustainable/list', [SustainableSolutionsController::class, 'list'])->name('sustainable-solutions.list');
    Route::get('/sustainable/{id}/{slug}', [SustainableSolutionsController::class, 'details'])->name('sustainable-solutions.details');

    Route::get('/intelligence', [SolutionsIntelligenceController::class, 'index'])->name('intelligence.index');
    Route::get('/intelligence/search/{qry}', [SolutionsIntelligenceController::class, 'search'])->name('intelligence.search');
    Route::post('/intelligence/list', [SolutionsIntelligenceController::class, 'list'])->name('intelligence.list');
    Route::get('/intelligence/{slug}', [SolutionsIntelligenceController::class, 'details'])->name('intelligence.details');
});

Route::prefix('resources-news')->name('resources-news.')->group(function () {
    Route::get('/digital-exhibition-conference-2025', [ConferenceController::class, 'index'])->name('digital-exhibition-conference-2022.index');
});

Route::get('/page/{slug}', [HomeController::class, 'page'])->name('static.page');
Route::get('/privacy-policy',[HomeController::class,'privacy_policy'])->name('privacy_policy');
Route::get('/search/{keyword}', [HomeController::class, 'search'])->name('search');



// Conforme
Route::get('/conforme/{token}/{status}', [ConformeController::class, 'handle_conforme_response'])
    ->name('conforme.handle.response')
    ->where(['status' => '[01]']);


// B2B SSO Endpoint Sync Function 
// This route is used to authorize the user and send them back to the B2B portal with a signed token.
// DO NOT DELETE this route as it is used for SSO between the main site and the B2B portal.
Route::get('/sso/authorize', [\App\Http\Controllers\SSOController::class, 'authorizeB2B']);

// ==========================================
// BUYER PORTAL ROUTES (user_group = 3)
// ==========================================
Route::middleware(['auth'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    
    // My Account Management Feature
    Route::get('/account', [BuyerController::class, 'account'])->name('account');
    Route::put('/account/update', [BuyerController::class, 'updateAccount'])->name('account.update');
    
    // Events Management Feature
    Route::get('/events', [BuyerController::class, 'events'])->name('events');
    
    // Bookmark Feature
    Route::get('/bookmarks', [BuyerController::class, 'bookmarks'])->name('bookmarks');
    Route::post('/bookmarks/toggle', [BuyerController::class, 'toggleBookmark'])->name('bookmarks.toggle');
});