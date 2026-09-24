<?php

use App\Http\Controllers\Supplier\AccountInformationController as SupplierInformationController;
use App\Http\Controllers\Supplier\ApiController as SupplierApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SustainableController;
use App\Http\Controllers\Admin\IntelligenceController;
use App\Http\Controllers\Admin\OnDemandResourceController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProgramOfferController;
use App\Http\Controllers\Admin\MetaTagsController;
use App\Http\Controllers\Admin\UserAccountController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BoothSystemAssignmentController;
use App\Http\Controllers\Admin\BoothSystemAssignmentGroupController;
use App\Http\Controllers\Admin\BuyerController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ConferenceController;
use App\Http\Controllers\Admin\ConferenceDelegate\DelegateController;
use App\Http\Controllers\Admin\ConferenceSoaController;
use App\Http\Controllers\Admin\DomesticSalesController;
use App\Http\Controllers\Admin\ExportSalesController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RetailSalesController;
use App\Http\Controllers\Admin\RtbController;
use App\Http\Controllers\Admin\SalesInquiriesController;
use App\Http\Controllers\Admin\VideoConferenceController;
use App\Http\Controllers\Admin\SalesActivityController;
use App\Http\Controllers\Admin\SalesManagementController;
use App\Http\Controllers\Website\DelegateConferenceController;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Permission;

use App\Models\User;
use App\Modules\InternalEvent\Promo\Controllers\Admin\Api\PromoUserController as ApiPromoUserController;
use App\Modules\InternalEvent\Promo\Controllers\Admin\Blade\PromoUserController as BladePromoUserController;


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
Route::prefix('admin')->name('admin.')->middleware(['auth','backend'])->group(function () {

    // Route::get('/linkstorage', function () {
    // Artisan::call('storage:link');});
    // }

    Route::get('/permission-cache-reset', function () {
    Artisan::call('permission:cache-reset');
    return 'Permission cache has been reset.';
});

    Route::get('/routes-cache', function () {
    Artisan::call('route:cache');
    return 'Route cache successfully';
});

    Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache successfully';
});

   Route::get('/view-cache', function () {
    Artisan::call('view:cache');
    return 'View cache successfully';
});


    Route::get('permission', function(Request $request) {
        //Permission::create(['name' => 'view dashboard']);
        // Permission::create(['name' => 'view carousel']);
        // Permission::create(['name' => 'delete carousel']);
        // Permission::create(['name' => 'edit carousel']);
        // Permission::create(['name' => 'add carousel']);
        // Permission::create(['name' => 'view reg_suppliers']);
        // Permission::create(['name' => 'resend reg_suppliers']);
        // Permission::create(['name' => 'review reg_suppliers']);
        // Permission::create(['name' => 'approve reg_suppliers']);
        // Permission::create(['name' => 'onhold reg_suppliers']);
        // Permission::create(['name' => 'disapprove reg_suppliers']);
        // Permission::create(['name' => 'view reg_buyers']);
        // Permission::create(['name' => 'resend reg_buyers']);
        // Permission::create(['name' => 'review reg_buyers']);
        // Permission::create(['name' => 'approve reg_buyers']);
        // Permission::create(['name' => 'onhold reg_buyers']);
        // Permission::create(['name' => 'disapprove reg_buyers']);
        // Permission::create(['name' => 'view articles']);
        // Permission::create(['name' => 'delete articles']);
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'add articles']);
        // Permission::create(['name' => 'view sustainable']);
        // Permission::create(['name' => 'delete sustainable']);
        // Permission::create(['name' => 'edit sustainable']);
        // Permission::create(['name' => 'add sustainable']);
        // Permission::create(['name' => 'view intelligence']);
        // Permission::create(['name' => 'delete intelligence']);
        // Permission::create(['name' => 'edit intelligence']);
        // Permission::create(['name' => 'add intelligence']);
        Permission::create(['name' => 'add reg_suppliers']);
    });

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

    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('events-activities', [EventController::class, 'index'])->name('events-activities.index')->middleware('permission:view events');
    Route::get('events-activities/create', [EventController::class, 'create'])->name('events-activities.create')->middleware('permission:add events');
    Route::post('events-activities', [EventController::class, 'store'])->name('events-activities.store')->middleware('permission:add events');
    Route::get('events-activities/{id}/edit', [EventController::class, 'edit'])->name('events-activities.edit')->middleware('permission:edit events');
    Route::put('events-activities/{id}', [EventController::class, 'update'])->name('events-activities.update')->middleware('permission:edit events');
    Route::delete('events-activities/{id}', [EventController::class, 'destroy'])->name('events-activities.destroy')->middleware('permission:delete events');
    Route::post('events-activities/list', [EventController::class, 'list'])->name('events-activities.list')->middleware('permission:view events');

    Route::get('news-articles', [ArticleController::class, 'index'])->name('news-articles.index')->middleware('permission:view articles');
    Route::get('news-articles/create', [ArticleController::class, 'create'])->name('news-articles.create')->middleware('permission:add articles');
    Route::post('news-articles', [ArticleController::class, 'store'])->name('news-articles.store')->middleware('permission:add articles');
    Route::get('news-articles/{id}', [ArticleController::class, 'show'])->name('news-articles.show')->middleware('permission:view articles');
    Route::get('news-articles/{id}/edit', [ArticleController::class, 'edit'])->name('news-articles.edit')->middleware('permission:edit articles');
    Route::put('news-articles/{id}', [ArticleController::class, 'update'])->name('news-articles.update')->middleware('permission:edit articles');
    Route::delete('news-articles/{id}', [ArticleController::class, 'destroy'])->name('news-articles.destroy')->middleware('permission:delete articles');
    Route::post('news-articles/list', [ArticleController::class, 'list'])->name('news-articles.list')->middleware('permission:view articles');


    Route::prefix('articles')->name('articles.')->group(function () {
        // Route::resource('sustainable-solutions', \SustainableController::class)->except([
        //     'show'
        // ]);
        // Route::post('sustainable-solutions/list', [SustainableController::class, 'list'])->name('sustainable-solutions.list');

        Route::get('solutions-intelligence', [IntelligenceController::class, 'index'])->name('solutions-intelligence.index')->middleware('permission:view intelligence');
        Route::get('solutions-intelligence/create', [IntelligenceController::class, 'create'])->name('solutions-intelligence.create')->middleware('permission:add intelligence');
        Route::post('solutions-intelligence', [IntelligenceController::class, 'store'])->name('solutions-intelligence.store')->middleware('permission:add intelligence');
        Route::get('solutions-intelligence/{id}', [IntelligenceController::class, 'show'])->name('solutions-intelligence.show')->middleware('permission:view intelligence');
        Route::get('solutions-intelligence/{id}/edit', [IntelligenceController::class, 'edit'])->name('solutions-intelligence.edit')->middleware('permission:edit intelligence');
        Route::put('solutions-intelligence/{id}', [IntelligenceController::class, 'update'])->name('solutions-intelligence.update')->middleware('permission:edit intelligence');
        Route::delete('solutions-intelligence/{id}', [IntelligenceController::class, 'destroy'])->name('solutions-intelligence.destroy')->middleware('permission:delete intelligence');
        Route::post('solutions-intelligence/list', [IntelligenceController::class, 'list'])->name('solutions-intelligence.list')->middleware('permission:view intelligence');

        Route::get('on-demand-resources', [OnDemandResourceController::class, 'index'])->name('on-demand-resources.index')->middleware('permission:view ondemand');
        Route::get('on-demand-resources/create', [OnDemandResourceController::class, 'create'])->name('on-demand-resources.create')->middleware('permission:add ondemand');
        Route::post('on-demand-resources', [OnDemandResourceController::class, 'store'])->name('on-demand-resources.store')->middleware('permission:add ondemand');
        Route::get('on-demand-resources/{id}', [OnDemandResourceController::class, 'show'])->name('on-demand-resources.show')->middleware('permission:view ondemand');
        Route::get('on-demand-resources/{id}/edit', [OnDemandResourceController::class, 'edit'])->name('on-demand-resources.edit')->middleware('permission:edit ondemand');
        Route::put('on-demand-resources/{id}', [OnDemandResourceController::class, 'update'])->name('on-demand-resources.update')->middleware('permission:edit ondemand');
        Route::delete('on-demand-resources/{id}', [OnDemandResourceController::class, 'destroy'])->name('on-demand-resources.destroy')->middleware('permission:delete ondemand');
        Route::post('on-demand-resources/list', [OnDemandResourceController::class, 'list'])->name('on-demand-resources.list')->middleware('permission:view ondemand');
    });

    Route::prefix('export-enablers')->name('export-enablers.')->group(function () {
        Route::get('companies', [CompanyController::class, 'index'])->name('companies.index')->middleware('permission:view enablers');
        Route::get('companies/create', [CompanyController::class, 'create'])->name('companies.create')->middleware('permission:add enablers');
        Route::post('companies', [CompanyController::class, 'store'])->name('companies.store')->middleware('permission:add enablers');
        Route::get('companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit')->middleware('permission:edit enablers');
        Route::put('companies/{id}', [CompanyController::class, 'update'])->name('companies.update')->middleware('permission:edit enablers');
        Route::delete('companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('permission:delete enablers');
        Route::post('companies/list', [CompanyController::class, 'list'])->name('companies.list')->middleware('permission:view enablers');

        Route::get('programs-offers', [ProgramOfferController::class, 'index'])->name('programs-offers.index')->middleware('permission:view offers');
        Route::get('programs-offers/create', [ProgramOfferController::class, 'create'])->name('programs-offers.create')->middleware('permission:add offers');
        Route::post('programs-offers', [ProgramOfferController::class, 'store'])->name('programs-offers.store')->middleware('permission:add offers');
        Route::get('programs-offers/{id}', [ProgramOfferController::class, 'show'])->name('programs-offers.show')->middleware('permission:view offers');
        Route::get('programs-offers/{id}/edit', [ProgramOfferController::class, 'edit'])->name('programs-offers.edit')->middleware('permission:edit offers');
        Route::put('programs-offers/{id}', [ProgramOfferController::class, 'update'])->name('programs-offers.update')->middleware('permission:edit offers');
        Route::delete('programs-offers/{id}', [ProgramOfferController::class, 'destroy'])->name('programs-offers.destroy')->middleware('permission:delete offers');
        Route::post('programs-offers/list', [ProgramOfferController::class, 'list'])->name('programs-offers.list')->middleware('permission:view offers');
    });

    Route::get('carousel-banners', [CarouselController::class, 'index'])->name('carousel-banners.index')->middleware('permission:view carousel');
    Route::get('carousel-banners/create', [CarouselController::class, 'create'])->name('carousel-banners.create')->middleware('permission:add carousel');
    Route::post('carousel-banners', [CarouselController::class, 'store'])->name('carousel-banners.store')->middleware('permission:add carousel');
    Route::get('carousel-banners/{id}/edit', [CarouselController::class, 'edit'])->name('carousel-banners.edit')->middleware('permission:edit carousel');
    Route::put('carousel-banners/{id}', [CarouselController::class, 'update'])->name('carousel-banners.update')->middleware('permission:edit carousel');
    Route::delete('carousel-banners/{id}', [CarouselController::class, 'destroy'])->name('carousel-banners.destroy')->middleware('permission:delete carousel');
    Route::post('carousel-banners/list', [CarouselController::class, 'list'])->name('carousel-banners.list')->middleware('permission:view carousel');

    Route::get('widgets', [WidgetController::class, 'index'])->name('widgets.index')->middleware('permission:view widgets');
    Route::get('widgets/create', [WidgetController::class, 'create'])->name('widgets.create')->middleware('permission:add widgets');
    Route::post('widgets', [WidgetController::class, 'store'])->name('widgets.store')->middleware('permission:add widgets');
    Route::get('widgets/{id}/edit', [WidgetController::class, 'edit'])->name('widgets.edit')->middleware('permission:edit widgets');
    Route::put('widgets/{id}', [WidgetController::class, 'update'])->name('widgets.update')->middleware('permission:edit widgets');
    Route::delete('widgets/{id}', [WidgetController::class, 'destroy'])->name('widgets.destroy')->middleware('permission:delete widgets');
    Route::post('widgets/list', [WidgetController::class, 'list'])->name('widgets.list')->middleware('permission:view widgets');

    Route::get('certifications', [CertificationController::class, 'index'])->name('certifications.index')->middleware('permission:view certifications');
    Route::get('certifications/create', [CertificationController::class, 'create'])->name('certifications.create')->middleware('permission:add certifications');
    Route::post('certifications', [CertificationController::class, 'store'])->name('certifications.store')->middleware('permission:add certifications');
    Route::get('certifications/{id}/edit', [CertificationController::class, 'edit'])->name('certifications.edit')->middleware('permission:edit certifications');
    Route::put('certifications/{id}', [CertificationController::class, 'update'])->name('certifications.update')->middleware('permission:edit certifications');
    Route::delete('certifications/{id}', [CertificationController::class, 'destroy'])->name('certifications.destroy')->middleware('permission:delete certifications');
    Route::post('certifications/list', [CertificationController::class, 'list'])->name('certifications.list')->middleware('permission:view certifications');

    Route::get('pages-meta-tags', [MetaTagsController::class, 'index'])->name('pages-meta-tags.index')->middleware('permission:view seo');
    Route::get('pages-meta-tags/{id}/edit', [MetaTagsController::class, 'edit'])->name('pages-meta-tags.edit')->middleware('permission:edit seo');
    Route::put('pages-meta-tags/{id}', [MetaTagsController::class, 'update'])->name('pages-meta-tags.update')->middleware('permission:edit seo');
    Route::post('pages-meta-tags/list', [MetaTagsController::class, 'list'])->name('pages-meta-tags.list')->middleware('permission:view seo');

    Route::resource('user-accounts', \UserAccountController::class)->except([
        'show'
    ]);
    Route::post('user-accounts/list', [UserAccountController::class, 'list'])->name('user.accounts.list');
    Route::get('user-accounts/suspend/{id}', [UserAccountController::class, 'suspend'])->name('user.accounts.suspend');
    Route::get('user-accounts/activate/{id}', [UserAccountController::class, 'activate'])->name('user.accounts.activate');
    
    Route::get('accounts/change-password', [AccountController::class, 'index'])->name('my.accounts.change_password.index');
    Route::put('accounts/change-password', [AccountController::class, 'update'])->name('my.accounts.change_password.update');

    Route::get('registration/suppliers', [RegistrationController::class, 'suppliers'])->name('suppliers.registration')->middleware('permission:view reg_suppliers');
    Route::get('registration/suppliers/create', [RegistrationController::class, 'suppContinue with registrationlier_create'])->name('suppliers.registration.create')->middleware('permission:add reg_suppliers');
    Route::post('registration/supplier/update', [RegistrationController::class, 'supplier_update'])->name('suppliers.registration.update')->middleware('permission:edit reg_suppliers');
    // Route::post('registration/supplier/store', [RegistrationController::class, 'supplier_store'])->name('suppliers.registration.store')->middleware('permission:add reg_suppliers');
    Route::post('registration/supplier/store', [RegistrationController::class, 'supplier_store'])->name('suppliers.registration.store')->middleware('permission:edit reg_suppliers');
    Route::post('registration/suppliers/list', [RegistrationController::class, 'supplier_list'])->name('suppliers.registration.list')->middleware('permission:view reg_suppliers');
    Route::get('registration/suppliers/{id}/{fair_code}/view', [RegistrationController::class, 'view'])->name('suppliers.registration.view')->middleware('permission:view reg_suppliers');


     Route::get('registration/supplier-information/{id}/{fair_code}', [RegistrationController::class,'supplier_info'])->middleware('permission:view reg_suppliers');
    Route::get('registration/resend/{id}/link', [RegistrationController::class, 'resend_registation_link'])->name('registration.resend.link')->middleware('permission:resend reg_suppliers|resend reg_buyers');
    Route::get('registration/review/{id}/application', [RegistrationController::class, 'review'])->name('registration.review.application')->middleware('permission:review reg_suppliers|review reg_buyers');
    Route::get('registration/reverttoinc/{id}/application', [RegistrationController::class, 'revert_to_inc'])->name('registration.reverttoinc.application')->middleware('permission:review reg_suppliers');
        Route::get('registration/pending/{id}/application', [RegistrationController::class, 'pending'])->name('registration.pending.application')->middleware('permission:pending reg_suppliers');
    Route::get('registration/approve/{id}/application', [RegistrationController::class, 'approve'])->name('registration.approve.application')->middleware('permission:approve reg_suppliers|approve reg_buyers');
    Route::get('registration/deny/{id}/application', [RegistrationController::class, 'deny'])->name('registration.deny.application')->middleware('permission:disapprove reg_suppliers|disapprove reg_buyers');
    Route::get('registration/onhold/{id}/application', [RegistrationController::class, 'onhold'])->name('registration.onhold.application')->middleware('permission:onhold reg_suppliers|onhold reg_buyers');
    Route::post('/registration/supplier/products/store', [RegistrationController::class, 'supplier_product_store'])->name('registration.supplier.product.store')->middleware('permission:edit reg_suppliers');
    
    // !Conforme 
      Route::post('/registration/supplier/conforme-review', [RegistrationController::class, 'conforme_review'])->name('registration.supplier.conforme-review')->middleware('permission:conforme reg_suppliers');
      // !Resend Conforme
Route::post(
    '/registration/supplier/resend-conforme',
    [RegistrationController::class, 'resend_conforme']
)->name('registration.supplier.resend-conforme')
 ->middleware('permission:conforme reg_suppliers');

    //! Additional Fees
    Route::post('/registration/supplier/cart/additional-fees/add', [RegistrationController::class, 'add_additional_fees'])->name('registration.supplier.additional-fee.store')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');
    Route::post('/registration/supplier/cart/additional-fees/delete', [RegistrationController::class, 'delete_additional_fees_cart_item'])->name('registration.supplier.additional-fees.delete')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');
    Route::post('/registration/supplier/cart/additional-fees/delete-all', [RegistrationController::class, 'delete_all_additional_fees_cart_items'])->name('registration.supplier.additional-fees.delete-all')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');

    //! Discounts
    Route::post('/registration/supplier/cart/discount/add', [RegistrationController::class, 'add_discount'])->name('registration.supplier.discount.store')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');
    Route::post('/registration/supplier/cart/discount/delete', [RegistrationController::class, 'delete_discount_cart_item'])->name('registration.supplier.discount.delete')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');
    Route::post('/registration/supplier/cart/discount/delete-all', [RegistrationController::class, 'delete_all_discount_cart_items'])->name('registration.supplier.discount.delete-all')->middleware('permission:edit reg_suppliers|conforme reg_suppliers');

    // ! Cart, Addon Cart, pitching cart
    Route::post('/registration/supplier/cart/add', [SupplierApiController::class, 'add_to_cart'])->name('supplier.cart.add.auth.admin');
    Route::post('/registration/supplier/addon-selection/add', [SupplierApiController::class, 'addAddOnSelection']);
    Route::post('/registration/supplier/addon-pitching-competition-selection/add', [SupplierApiController::class, 'addPitchingCompetitionAddOn']);
    Route::post('/registration/supplier/cart/delete', [SupplierApiController::class, 'delete_cart_item']);
    Route::post('/registration/supplier/cart/delete-all', [SupplierApiController::class, 'delete_all_cart_items']);
    Route::post('/registration/supplier/addon-cart/delete', [SupplierApiController::class, 'deleteAddOnSelection']);
    Route::post('/registration/supplier/addon-cart/delete-all', [SupplierApiController::class, 'deleteAllAddOnSelection']);


        //! Conference Delegates
    Route::prefix('registration/delegates')->name('registration.delegates.')->group(function () {
   
    //? API
        Route::post('/list', [DelegateController::class, 'list'])->name('list');
        Route::get('/{id}/details', [DelegateController::class, 'details'])->name('details');
        Route::prefix('/breakdown')->name('breakdown.')->group(function () {
            Route::post('/{id}/add-discount',[DelegateController::class, 'addDiscount'])->name('add-discount');
            Route::post('/{id}/add-fee',[DelegateController::class, 'addFee'])->name('add-dee');
            Route::delete('/{id}/delete',[DelegateController::class, 'deleteBreakdown'])->name('delete');
        });
        Route::post('/{conference}/add-delegate',[DelegateController::class, 'addDelegate']);
        Route::delete('/{delegate}',[DelegateController::class, 'deleteDelegate']);
        Route::put('/{id}/update',[DelegateController::class,'updateDelegate']);
        Route::post('/{id}/review',[DelegateController::class, 'review'])->name('review');
        Route::post('/{id}/send-email', [DelegateController::class, 'sendEmail'])->name('send-email');
        Route::post('/{id}/generate-soa',[ConferenceSoaController::class, 'generateSoaBilling'])->name('generate-soa');
        Route::post('/{id}/submit-for-approval',[ConferenceSoaController::class, 'submitForApproval'] );
        Route::post('/{id}/return-to-generated',[ConferenceSoaController::class, 'returnToGenerated'])->name('return-to-generated');
        Route::post('/{id}/approve-billing',[ConferenceSoaController::class, 'approveBilling'])->name('approve-billing');
        Route::post('/{conference}/generate-qr',[DelegateController::class, 'generateAllQr'])->name('generate-qr');
        Route::get('/certifications/download',[DelegateController::class, 'downloadCertifications'])->name('certifications.download');
            
    //? Blade
        Route::get('/', [DelegateController::class, 'index'])->name('index');
        Route::get('/view/{id}', [DelegateController::class, 'view'])->name('view');

   
    });

    // ! Conference
    Route::get('registration/conference', [RegistrationController::class, 'conference'])->name('conference.registration');
    Route::post('registration/suppliers/conference-list', [RegistrationController::class, 'conference_list'])->name('suppliers.registration.conference.list')->middleware('permission:view reg_suppliers');

    // ! RTB
    Route::post('/registration/generate-rtb', [RtbController::class, 'generate_rtb']);

    // ! SOA
    Route::post('/registration/mark-soa', [PaymentController::class, 'markSOA'])
    ->name('admin.registration.mark-soa');

    //! Promo Codes
    Route::prefix('promo-codes')->name('promo-codes.')->group(function () {
    
        //? API
        Route::post('/users/list', [ApiPromoUserController::class, 'list'])
            ->name('users.list');
        Route::post('/users/store', [ApiPromoUserController::class, 'store'])
            ->name('users.store');
        Route::delete('/users/{id}/delete', [ApiPromoUserController::class, 'destroy'])
            ->name('users.delete');
          Route::post('/generate-code', [ApiPromoUserController::class, 'generateCode'])
            ->name('generate-code');
        Route::put('/users/{promoUser}',[ApiPromoUserController::class, 'update']);

        //? Blade
        Route::get('/emails', [BladePromoUserController::class, 'index'])
        ->name('users.index');
    });


//! Booth System
Route::prefix('booth-system')->name('booth-system.')->group(function () {

    //? BLADE
    Route::get(
        '/',
        [BoothSystemAssignmentController::class, 'index']
    )->name('index');

    //? ASSIGNMENT API
    Route::post(
        '/list',
        [BoothSystemAssignmentController::class, 'list']
    )->name('list');

    Route::post(
        '/assignments',
        [BoothSystemAssignmentController::class, 'store']
    )->name('store');

    Route::put(
        '/assignments/{id}',
        [BoothSystemAssignmentController::class, 'update']
    )->name('update');

    Route::delete(
        '/assignments/{id}',
        [BoothSystemAssignmentController::class, 'destroy']
    )->name('destroy');


    //? ASSIGNMENT GROUPS
    Route::prefix('assignments/{assignment}/groups')
        ->name('assignments.groups.')
        ->group(function () {

            // View Groups Blade
            Route::get(
                '/',
                [BoothSystemAssignmentGroupController::class, 'index']
            )->name('index');

     
            Route::post(
                '/list',
                [BoothSystemAssignmentGroupController::class, 'list']
            )->name('list');

            Route::post(
                '/',
                [BoothSystemAssignmentGroupController::class, 'store']
            )->name('store');

           
            Route::put(
                '/{group}',
                [BoothSystemAssignmentGroupController::class, 'update']
            )->name('update');

          
            Route::delete(
                '/{group}',
                [BoothSystemAssignmentGroupController::class, 'destroy']
            )->name('destroy');

            Route::get(
            '/suppliers',
            [BoothSystemAssignmentGroupController::class, 'suppliers']
        )->name('suppliers');
        });
});
    

    //! Payments
    Route::prefix('payments')->name('payments.')->group(function () {
    
        //? API
            Route::post('/supplier-exhibitor/submit', [PaymentController::class, 'supplier_store']);
            Route::post('/supplier-exhibitor/mark-status', [PaymentController::class, 'markStatus']);

        //? Blade
        Route::get('/supplier-exhibitors', [PaymentController::class, 'supplier_index'])
        ->name('suppliers.exhibitors.index')->middleware('permission:view payments');
        Route::get('/supplier-exhibitor/{user}/{slug}/{fair_code}', [PaymentController::class, 'supplier_view'])->name('suppliers.exhibitors.view')->middleware('permission:view payments');
         Route::get('/supplier-exhibitor/attendance', [PaymentController::class, 'getSupplierPayment']);
    });
   

    
    Route::prefix('daily-sales-report')
    ->name('daily-sales-report.')
    ->group(function () {
      
        Route::prefix('/sales-activity')->name('sales-activity.')
            ->group(function () {
                Route::get('/', [SalesActivityController::class, 'index'])->name('index');  
                Route::delete('/{type}/{id}',[SalesActivityController::class, 'destroy'])->name('destroy');
                Route::post('/export',[SalesActivityController::class, 'export'])->name('export');
            });
         Route::prefix('/sales-management')->name('sales-management.')
            ->group(function () {
                Route::get('/', [SalesManagementController::class, 'index'])->name('index');  
                Route::get('/{user}',[SalesManagementController::class, 'salesManagement'])->name('sales_management');
                Route::get('/list/{sales_type}',[SalesManagementController::class, 'salesList'])->name('list');
                Route::post('/store',[SalesManagementController::class, 'storeSales'])->name('store');
                Route::delete('/delete/{id}',[SalesManagementController::class, 'deleteSale'])->name('delete');
                Route::put('/update/{id}',[SalesManagementController::class, 'update'])->name('update');

                Route::prefix('/inquiries')
                ->name('inquiries.')
                ->group(function () {

                    Route::get(
                        '/list',
                        [SalesManagementController::class, 'inquiriesList']
                    )->name('list');

                    Route::post(
                        '/store',
                        [SalesManagementController::class, 'storeInquiry']
                    )->name('store');

                    Route::delete(
                        '/delete/{id}',
                        [SalesManagementController::class, 'deleteInquiry']
                    )->name('delete');
                    Route::put('/update/{id}',[SalesManagementController::class, 'updateInquiry'])->name('update');
                });
            });

        Route::prefix('export-sales')->name('export-sales.')
            ->group(function () {
                Route::get('/', [ExportSalesController::class, 'index'])->name('index');
                Route::get('/export',[ExportSalesController::class, 'export'])->name('export');
            });
        Route::prefix('domestic-sales')->name('domestic-sales.')
            ->group(function () {
                Route::get('/', [DomesticSalesController::class, 'index'])->name('index');
                Route::get('/export',[DomesticSalesController::class, 'export'])->name('export');
            });
        Route::prefix('retail-sales')->name('retail-sales.')
            ->group(function () {
                Route::get('/', [RetailSalesController::class, 'index'])->name('index');
                Route::get('/export',[RetailSalesController::class, 'export'])->name('export');
               
                });
        Route::prefix('inquiries')->name('inquiries.')
            ->group(function () {
                Route::get('/', [SalesInquiriesController::class, 'index'])->name('index');
                Route::get('/export',[SalesInquiriesController::class, 'export'])->name('export');
            });
    });



    // ! Sponsorship
    Route::get('registration/sponsorship', [RegistrationController::class, 'sponsorship'])->name('sponsorship.registration');
    Route::post('registration/suppliers/sponsorship-list', [RegistrationController::class, 'sponsorship_list'])->name('suppliers.registration.sponsorship.list')->middleware('permission:view reg_suppliers');
    Route::get('registration/buyers', [RegistrationController::class, 'buyers'])->name('buyers.registration')->middleware('permission:view reg_buyers');
    Route::get('registration/buyers/create', [RegistrationController::class, 'purchaser_create'])->name('buyers.registration.create')->middleware('permission:add reg_purchaser');
    Route::post('registration/buyers/store', [RegistrationController::class, 'purchaser_store'])->name('buyers.registration.store')->middleware('permission:add reg_purchaser');
    Route::post('registration/buyers/update', [RegistrationController::class, 'purchaser_update'])->name('buyers.registration.update')->middleware('permission:update reg_purchaser');
    Route::post('registration/buyers/list', [RegistrationController::class, 'buyers_list'])->name('buyers.registration.list')->middleware('permission:view reg_buyers');
    Route::get('registration/buyers/{id}/{fair_code}/view', [RegistrationController::class, 'buyer_view'])->name('buyers.registration.view')->middleware('permission:view reg_buyers');
    Route::get('registration/buyer-information/{id}/{fair_code}', [RegistrationController::class,'buyer_information'])->middleware('permission:view reg_buyers');
    Route::post('registration/buyers/{buyer}/{fairCode}/generate-qr',[BuyerController::class, 'generateQr'])->name('buyers.registration.generate-qr');

    Route::get('pages', [PageController::class, 'index'])->name('pages.index')->middleware('permission:view pages');
    Route::get('pages/create', [PageController::class, 'create'])->name('pages.create')->middleware('permission:add pages');
    Route::post('pages', [PageController::class, 'store'])->name('pages.store')->middleware('permission:add pages');
    Route::get('pages/{id}', [PageController::class, 'show'])->name('pages.show')->middleware('permission:view pages');
    Route::get('pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit')->middleware('permission:edit pages');
    Route::put('pages/{id}', [PageController::class, 'update'])->name('pages.update')->middleware('permission:edit pages');
    Route::delete('pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('permission:delete pages');
    Route::post('pages/list', [PageController::class, 'list'])->name('pages.list')->middleware('permission:view pages');

    Route::get('exhibitions-conferences', [ConferenceController::class, 'index'])->name('exhibitions-conferences.index')->middleware('permission:view conference');
    Route::get('exhibitions-conferences/create', [ConferenceController::class, 'create'])->name('exhibitions-conferences.create')->middleware('permission:add conference');
    Route::post('exhibitions-conferences', [ConferenceController::class, 'store'])->name('exhibitions-conferences.store')->middleware('permission:add conference');
    Route::get('exhibitions-conferences/{id}/edit', [ConferenceController::class, 'edit'])->name('exhibitions-conferences.edit')->middleware('permission:edit conference');
    Route::put('exhibitions-conferences/{id}', [ConferenceController::class, 'update'])->name('exhibitions-conferences.update')->middleware('permission:edit conference');
    Route::delete('exhibitions-conferences/{id}', [ConferenceController::class, 'destroy'])->name('exhibitions-conferences.destroy')->middleware('permission:delete conference');
    Route::post('exhibitions-conferences/list', [ConferenceController::class, 'list'])->name('exhibitions-conferences.list')->middleware('permission:view conference');

    Route::get('conferences-videos', [VideoConferenceController::class, 'index'])->name('conferences-videos.index')->middleware('permission:view video');
    Route::get('conferences-videos/create', [VideoConferenceController::class, 'create'])->name('conferences-videos.create')->middleware('permission:add video');
    Route::post('conferences-videos', [VideoConferenceController::class, 'store'])->name('conferences-videos.store')->middleware('permission:add video');
    Route::get('conferences-videos/{id}/edit', [VideoConferenceController::class, 'edit'])->name('conferences-videos.edit')->middleware('permission:edit video');
    Route::put('conferences-videos/{id}', [VideoConferenceController::class, 'update'])->name('conferences-videos.update')->middleware('permission:edit video');
    Route::delete('conferences-videos/{id}', [VideoConferenceController::class, 'destroy'])->name('conferences-videos.destroy')->middleware('permission:delete video');
    Route::post('conferences-videos/list', [VideoConferenceController::class, 'list'])->name('conferences-videos.list')->middleware('permission:view video');

    Route::get('website-cache', [HomeController::class, 'website_cache'])->name('website.cache');
});






