<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Website\ApiController;
use App\Http\Controllers\Admin\ApiController as AdminApi;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Website\RegistrationController;


/* SUPPLIER */
use App\Http\Controllers\Supplier\EventController as SupplierEventController;
use App\Http\Controllers\Supplier\RegistrationSupplierController as SupplierRegistrationController;
use App\Http\Controllers\Supplier\ApiController as SupplierApiController;
use App\Http\Controllers\Supplier\ExhibitorPaymentController;
use App\Http\Controllers\Supplier\ExportSalesController as SupplierExportSalesController;
use App\Http\Controllers\Supplier\DomesticSalesController as SupplierDomesticSalesController;
use App\Http\Controllers\Supplier\RetailSalesController as SupplierRetailSalesController;
use App\Http\Controllers\Admin\ExportSalesController as AdminExportSalesController;
use App\Http\Controllers\Admin\DomesticSalesController as AdminDomesticSalesController; 
use App\Http\Controllers\Admin\RetailSalesController as AdminRetailSalesController;
use App\Http\Controllers\Admin\SalesInquiriesController as AdminSalesInquiriesController;
use App\Http\Controllers\Admin\SalesActivityController as AdminSalesActivityController;
use App\Http\Controllers\Admin\SalesManagementController;
use App\Http\Controllers\Supplier\ProductController as SupplierProductController;

use App\Http\Controllers\Supplier\SalesInquiriesController as SupplierSalesInquiriesController;
use App\Modules\InternalEvent\Promo\Controllers\Admin\Api\PromoController as ApiPromoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('supplier')->group(function () {
    Route::get('/events', [SupplierEventController::class, 'getEvents']);
    Route::get('/user-information/{id}/{fair_code}', [SupplierRegistrationController::class,'user_information']);
    Route::get('/user-docs/{user_id}/{fair_code}', [SupplierRegistrationController::class,'user_docs']);
    Route::get('/pick_topics', [SupplierApiController::class, 'pick_topics']);
    Route::get('/events/{id}', [SupplierApiController::class, 'getSpecificEvent']);
    Route::post('/check-cart-booth-sizes', [SupplierApiController::class, 'check_cart_booth_sizes']);
    Route::post('/check-group-cart-booth-sizes', [SupplierApiController::class, 'check_group_cart_booth_sizes']);
    Route::get('/packages', [SupplierApiController::class, 'getPackages']);
    Route::get('/cart/fetch/{user_id}/{fair_code}', [SupplierApiController::class, 'fetch_cart']);
    Route::get('/mandatory/fetch/{user_id}/{fair_code}', [SupplierApiController::class, 'fetchParticipationMandatory']);
    Route::get('/addon-rates/{business_type_id}/{fair_code}', [SupplierApiController::class, 'fetchAddOnRatesByBusinessTypeAndFair']);
    Route::get('/addon-cart/fetch/{user_id}/{fair_code}', [SupplierApiController::class, 'fetchAddonCart']);
    Route::get('/cart/fetch/additional-fees', [SupplierApiController::class, 'fetch_additional_fees']);
    Route::get('/cart/fetch/discount', [SupplierApiController::class, 'fetch_discounts']);
    Route::post('/upload-documents/delete-all', [SupplierApiController::class, 'deleteAllDocuments']);
    Route::get('/user-agreement/registration', [SupplierApiController::class, 'fetchAllAgreements']);
    Route::get('/user-information/{id}',[SupplierApiController::class, 'user_info_by_id']);
    Route::post('/product/list', [SupplierApiController::class, 'product_list']);
    Route::get('/product-information/{supplier_id}/{product_id}', [SupplierApiController::class, 'getProductInformation']);
    Route::post('/product/add', [SupplierApiController::class, 'storeOrUpdateProduct']);
    Route::post('/account/update', [SupplierApiController::class, 'storeNewProduct']);
    //! Payments
    Route::post('/payment/event-list', [SupplierApiController::class, 'payment_event_list']);
    Route::get('/payment/event/latest-payment', [ExhibitorPaymentController::class, 'getLatestPayment']);
    Route::post('/payment/event/submit', [ExhibitorPaymentController::class, 'store']);
    //! Export Sales

    Route::post('/daily-sales-report/export-sales/list', [SupplierExportSalesController::class, 'export_sales_index']);
    Route::get('/daily-sales-report/export-sales/{id}', [SupplierExportSalesController::class, 'show']);
    //! Domestic Sales
    Route::post('/daily-sales-report/domestic-sales/list', [SupplierDomesticSalesController::class, 'domestic_sales_index']);
    Route::get('/daily-sales-report/domestic-sales/{id}', [SupplierDomesticSalesController::class, 'show']);
    //! Retail Sales
    Route::post('/daily-sales-report/retail-sales/list', [SupplierRetailSalesController::class, 'retail_sales_index']);
    Route::get('/daily-sales-report/retail-sales/{id}', [SupplierRetailSalesController::class, 'show']);
    // ! Inquiries
    Route::post('/daily-sales-report/inquiries/list',[SupplierSalesInquiriesController::class, 'inquiries_index']);
    Route::get('/daily-sales-report/inquiries/{id}',[SupplierSalesInquiriesController::class, 'show']);
    });


    Route::prefix('admin')->group(function () {
    Route::get('/user-information/{id}/{fair_code}', [AdminRegistrationController::class,'user_information']);
    Route::get('/buyer-information/{id}/{fair_code}', [AdminRegistrationController::class,'buyer_information']);
    Route::get('/payments/supplier-exhibitor/attendance', [PaymentController::class, 'getSupplierPayment']);

    //! Sales Activity
    Route::post('/daily-sales-report/sales-activity/list', [AdminSalesActivityController::class, 'sales_activity_index']);
     Route::get('/daily-sales-report/sales-management/list',[SalesManagementController::class, 'salesManagementSuppliers']);
    Route::get('/sales-management/{user}',[SalesManagementController::class, 'salesManagementDetails']);
    //! Export Sales
    Route::post('/daily-sales-report/export-sales/list', [AdminExportSalesController::class, 'export_sales_index']);
    //! Domestic Sales
    Route::post('/daily-sales-report/domestic-sales/list', [AdminDomesticSalesController::class, 'domestic_sales_index']);
       //! Retail Sales
    Route::post('/daily-sales-report/retail-sales/list', [AdminRetailSalesController::class, 'retail_sales_index']);
      // ! Inquiries
    Route::post('/daily-sales-report/inquiries/list',[AdminSalesInquiriesController::class, 'inquiries_index']);
    });
    



Route::get('/countries', [ApiController::class, 'countries']);
Route::get('/check-company-email-unique/{email}/{type}', [ApiController::class, 'check_company_email_unique']);
Route::get('/check-company-email-exist/{email}/{type}', [ApiController::class, 'check_company_email_exist']);
Route::get('/check-business-name-unique/{name}/{type}', [ApiController::class, 'check_business_name_unique']);
Route::get('/user-information/{id}', [RegistrationController::class, 'user_information']);


Route::get('/product-information/{id}', [RegistrationController::class, 'product_information']);
Route::delete('/product/photo/delete/{id}', [ApiController::class, 'delete_product_photo']);
Route::delete('/product/delete/{id}', [ApiController::class, 'delete_product']);

Route::post('/delete/image', [AdminApi::class, 'delete_image']);
Route::post('/wysiwyg/upload', [AdminApi::class, 'wysiwyg_image_upload']);
Route::get('/business_types', [ApiController::class, 'business_types']);
Route::get('/active_business_types', [ApiController::class, 'active_business_types']);
Route::get('/company_sizes', [ApiController::class, 'company_sizes']);
Route::get('/annual_sales_volumes', [ApiController::class, 'annual_sales_volumes']);
Route::get('/organization_types', [ApiController::class, 'organization_types']);
Route::get('/nature_businesses', [ApiController::class, 'nature_businesses']);
Route::get('/certifications', [ApiController::class, 'certifications']);
Route::get('/categories', [ApiController::class, 'categories']);
Route::get('/categories-pillar', [ApiController::class, 'categories_pillar']);
Route::get('/categories/is-startup', [ApiController::class, 'categories_is_startup']);
Route::get('/categories/group-all', [ApiController::class, 'categories_group_all']);
Route::get('/annual_purchase_existing_supplier', [ApiController::class, 'annual_purchase_existing_supplier']);
Route::get('/company_annual_sales', [ApiController::class, 'company_annual_sales']);

Route::get('/categories/filter', [ApiController::class, 'categoriesByStartUp']);
Route::get('/enablers-categories', [ApiController::class, 'enablers_categories']);
Route::get('/target_buyers', [ApiController::class, 'target_buyers']);
Route::get('/honorifics', [ApiController::class, 'honorifics']);
Route::get('/roles', [ApiController::class, 'company_roles']);
Route::get('/regions', [ApiController::class, 'regions']);
Route::get('/participation_goals', [ApiController::class, 'participation_goals']);
Route::get('/participation_goals_sdg', [ApiController::class, 'participation_goals_sdg']);
Route::get('/learn_about_event', [ApiController::class, 'learn_about_event']);
Route::get('/sdg',[ApiController::class, 'sdg']);
Route::get('/on_input_output', [ApiController::class, 'on_input_output']);
Route::get('/on_production_process', [ApiController::class, 'on_production_process']);
Route::get('/rank_topics', [ApiController::class, 'rank_topics']);
Route::get('/banner_sizes', [ApiController::class, 'banner_sizes']);
Route::get('/article_types', [ApiController::class, 'article_types']);
Route::get('/exhibitions-conferences', [ApiController::class, 'exhibitions_conferences']);
Route::post('/document/delete', [ApiController::class, 'delete_document']);
Route::get('/widgets/{id}', [ApiController::class, 'widgets']);

Route::post('/contact-us', [ApiController::class, 'contact_us_store'])->name('contactus.store');
Route::post('/subscribe', [ApiController::class, 'subcription_store'])->name('subscription.store');

Route::post('/sitewide/search', [ApiController::class, 'search'])->name('search.sitewide');

Route::get('/clear-cache', [AdminApi::class, 'clear_cache']);
Route::get('/clear-view', [AdminApi::class, 'clear_view']);
Route::get('/clear-route', [AdminApi::class, 'clear_route']);
Route::get('/clear-config', [AdminApi::class, 'clear_config']);
Route::get('/cache-config', [AdminApi::class, 'cache_config']);
Route::get('/cache-route', [AdminApi::class, 'cache_route']);
Route::get('/cache-view', [AdminApi::class, 'cache_view']);

Route::get('/dashboard/suppliers/summary', [AdminApi::class, 'suppliers_summary']);
Route::get('/dashboard/purchasers/summary', [AdminApi::class, 'purchaser_summary']);


    //! Promo Codes
    Route::prefix('promo-codes')->name('promo-codes.')->group(function () {
     
     Route::post('/promos', [ApiPromoController::class, 'index']);
     Route::post('/allowed-attendee-types', [ApiPromoController::class, 'getAllowedAttendeeTypes']);
      
    });


// ! For Fair Code
Route::get('/dashboard/suppliers/summary/fair', [AdminApi::class, 'suppliers_summary_fair']);
Route::get('/dashboard/purchasers/summary/fair', [AdminApi::class, 'purchaser_summary_fair']);
Route::get('/dashboard/conference/summary/fair',[AdminApi::class, 'conference_summary_fair']);

Route::get('/attendee-types', [ApiController::class, 'attendeeTypes']);