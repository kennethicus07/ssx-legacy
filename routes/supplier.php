<?php

use App\Http\Controllers\Supplier\AccountInformationController;
use App\Http\Controllers\Supplier\ApiController;
use App\Http\Controllers\Supplier\EventController;
use App\Http\Controllers\Supplier\ExhibitorPaymentController;
use App\Http\Controllers\Supplier\ExportSalesController;
use App\Http\Controllers\Supplier\DomesticSalesController;
use App\Http\Controllers\Supplier\HomeController;
use App\Http\Controllers\Supplier\RegistrationSupplierController;
use App\Http\Controllers\Supplier\SupplierVerificationController;use App\Http\Controllers\Supplier\ProductController;
use App\Http\Controllers\Supplier\RetailSalesController;
use App\Http\Controllers\Supplier\SalesInquiriesController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Routes requiring supplier login
Route::prefix('supplier')->name('supplier.')->middleware(['supplier'])->group(function () {

    // Dashboard
    Route::get('/', [EventController::class, 'index'])->name('dashboard');

    // Route::get('events', [EventController::class, 'index'])->name('events');

     Route::get('/events-for-supplier', [EventController::class, 'getEventsForSupplier']);

    Route::get('account-information', [AccountInformationController::class, 'view'])->name('account-information');

        Route::get('accounts/change-password', [AccountInformationController::class, 'index'])->name('my.accounts.change_password.index');
    Route::put('accounts/change-password', [AccountInformationController::class, 'update'])->name('my.accounts.change_password.update');
   
    Route::post('logout', function (Request $request) {
        $user = Auth::guard('supplier')->user();

        if ($user) {
            activity('logged-out')
                ->causedBy($user)
                ->log('Supplier logged out');
        }

        Auth::guard('supplier')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.index');
    })->name('logout');

    Route::get('registration/{slug}', [RegistrationSupplierController::class, 'supplier_registration'])->name('registration.supplier.steps')->middleware('no.cache');


    Route::post('registration/store', [RegistrationSupplierController::class, 'supplier_store'])->name('registration.supplier.store'); 

    Route::post('account-information/store',[AccountInformationController::class,'account_info_store'])->name('account.supplier.store');

    Route::get('registration/thankyou/{id}/{fair_code}', [RegistrationSupplierController::class, 'supplier_registration_thankyou'])->name('registration.supplier.thankyou');

    Route::put('registration/receive-updates/{id}', [RegistrationSupplierController::class, 'supplier_receive_updates'])->name('registration.supplier.receive.updates');

     Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/view', [ProductController::class, 'view'])->name('view');
        Route::get('/add',[ProductController::class, 'add'])->name('add');
    });

     Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/event-list', [EventController::class, 'event_payments_list'])->name('events.index');
        Route::get('/event/{slug}', [EventController::class, 'viewEventPayment'])->name('event.view');
     
    });


    Route::prefix('daily-sales-report')
    ->name('daily-sales-report.')
    ->group(function () {
        Route::prefix('export-sales')->name('export-sales.')
            ->group(function () {
                Route::get('/', [ExportSalesController::class, 'index'])->name('index');
                Route::get('/create', [ExportSalesController::class, 'create'])->name('create');
                Route::post('/store',[ExportSalesController::class,'store'])->name('store');
                Route::get('/{id}/edit', [ExportSalesController::class, 'edit'])->name('edit');
                // Route::get('/{id}', [ExportSalesController::class, 'show'])->name('show');
                Route::put('/{id}', [ExportSalesController::class, 'update'])->name('update');
                Route::delete('/{id}',[ExportSalesController::class,'destroy'])->name('destroy');
            });
        Route::prefix('domestic-sales')->name('domestic-sales.')
            ->group(function () {
                Route::get('/', [DomesticSalesController::class, 'index'])->name('index');
                Route::get('/create', [DomesticSalesController::class, 'create'])->name('create');
                Route::post('/store',[DomesticSalesController::class,'store'])->name('store');
                Route::get('/{id}/edit', [DomesticSalesController::class, 'edit'])->name('edit');
                Route::put('/{id}', [DomesticSalesController::class, 'update'])->name('update');
                Route::delete('/{id}',[DomesticSalesController::class,'destroy'])->name('destroy');
            });
        Route::prefix('retail-sales')->name('retail-sales.')
            ->group(function () {
                Route::get('/', [RetailSalesController::class, 'index'])->name('index');
                Route::get('/create', [RetailSalesController::class, 'create'])->name('create');
                Route::post('/store',[RetailSalesController::class,'store'])->name('store');
                Route::get('/{id}/edit', [RetailSalesController::class, 'edit'])->name('edit');
                Route::put('/{id}', [RetailSalesController::class, 'update'])->name('update');
                Route::delete('/{id}',[RetailSalesController::class,'destroy'])->name('destroy');
                });
        Route::prefix('inquiries')->name('inquiries.')
            ->group(function () {
                Route::get('/', [SalesInquiriesController::class, 'index'])->name('index');
                Route::get('/create', [SalesInquiriesController::class, 'create'])->name('create');
                Route::post('/store',[SalesInquiriesController::class,'store'])->name('store');
                Route::get('/{id}/edit', [SalesInquiriesController::class, 'edit'])->name('edit');
                Route::get('/{id}',[SalesInquiriesController::class, 'show']);
                Route::put('/{id}',[SalesInquiriesController::class, 'update']);
                Route::delete('/{id}',[SalesInquiriesController::class,'destroy'])->name('destroy');
            });
    });

 
    Route::post('/addon-pitching-competition-selection/add', [ApiController::class, 'addPitchingCompetitionAddOn']);
    Route::post('cart/add', [ApiController::class, 'add_to_cart'])->name('supplier.cart.add.auth');
    Route::post('/addon-selection/add', [ApiController::class, 'addAddOnSelection']);
       Route::post('/cart/delete', [ApiController::class, 'delete_cart_item']);
    Route::post('/addon-pitching-competition-selection/add', [ApiController::class, 'addPitchingCompetitionAddOn']);
    Route::post('/cart/delete-all', [ApiController::class, 'delete_all_cart_items']);
    Route::post('/addon-cart/delete', [ApiController::class, 'deleteAddOnSelection']);
    Route::post('/addon-cart/delete-all', [ApiController::class, 'deleteAllAddOnSelection']);

    
});


// Email verification route (NO supplier middleware)
Route::get('/supplier/verify/{id}', [SupplierVerificationController::class, 'verify'])
    ->name('verification.supplier.verify')
    ->middleware('signed'); // only checks signed URL
