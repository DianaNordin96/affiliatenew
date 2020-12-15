<?php

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('redirected','RedirectController@redirect');

Auth::routes();


Route::group(['middleware' => 'admin'], function () {
    
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('auth');
    Route::get('manageAgent', 'Admin\ManageAgentController@index')->name('manageAgent')->middleware('auth');
    Route::POST('manageAgent/create', 'Admin\ManageAgentController@create')->name('manageAgent.create')->middleware('auth');
    Route::get('manageAgent/delete/{id}', 'Admin\ManageAgentController@Delete')->middleware('auth');
    Route::POST('manageAgent/update', 'Admin\ManageAgentController@update')->name('manageAgent.update')->middleware('auth');
    Route::get('manageAgent/{role}/{id}', 'Admin\ManageAgentController@changeRole')->middleware('auth');
    Route::get('manageProduct', 'Admin\ManageProductController@index')->name('manageProduct')->middleware('auth');
    Route::POST('manageProduct/create', 'Admin\ManageProductController@create')->name('manageProduct.create')->middleware('auth');
    Route::get('manageProduct/delete/{id}', 'Admin\ManageProductController@delete')->name('manageProduct.delete')->middleware('auth');
    Route::POST('manageProduct/update', 'Admin\ManageProductController@update')->name('manageProduct.update')->middleware('auth');
    Route::get('view-order/{page}', 'Admin\ManageOrderController@index')->name('view-order')->middleware('auth');
    Route::get('view-order-item/{id}', 'Admin\ManageOrderController@viewItem')->middleware('auth');
    Route::get('customers', 'Admin\CustomerController@index')->middleware('auth');
    Route::get('profile-admin', 'Admin\ProfileController@index')->middleware('auth');
    Route::POST('profile-update-admin', 'Admin\ProfileController@update')->middleware('auth');
    Route::POST('change-password-admin', 'Admin\ProfileController@changePassword')->middleware('auth');
    Route::get('blastMessage', 'Admin\BlastMessageController@index')->middleware('auth');
    Route::POST('bulksms-send-agent', 'Admin\BlastMessageController@bulkSMSagent')->middleware('auth');
    Route::POST('singlesms-send', 'Admin\BlastMessageController@singleSMS')->middleware('auth');
    Route::POST('bulksms-send-customer', 'Admin\BlastMessageController@bulkSMScustomer')->middleware('auth');
    Route::POST('tracking-create', 'Admin\TrackingController@createTracking')->middleware('auth');
    Route::GET('consignment-note', 'Admin\ConsignmentController@index')->middleware('auth');
    Route::GET('parcel', 'Admin\ParcelController@index')->middleware('auth');
    Route::POST('parcel-create', 'Admin\ParcelController@create')->middleware('auth');
    Route::GET('add-to-cart-parcel/{desc}/{serv_id}/{price}', 'Admin\ParcelController@addToCartParcel')->middleware('auth');
    Route::GET('consignment-details', 'Admin\ParcelController@consignmentPage')->middleware('auth');
    Route::patch('update-cart', 'Admin\ParcelController@updateParcelCart')->middleware('auth');
    Route::patch('remove-cart', 'Admin\ParcelController@removeParcelCart')->middleware('auth');
    Route::POST('checkout-consignment', 'Admin\ParcelController@checkout')->middleware('auth');
    Route::GET('add-cart-admin/{refNo}/{price}', 'Admin\CartController@addToCart')->middleware('auth');
    Route::GET('remove-cart-admin/{refNo}', 'Admin\CartController@removeFromCart')->middleware('auth');
    Route::GET('checkout-admin', 'Admin\CartController@checkout')->middleware('auth');
    Route::GET('bulk-parcel', 'Admin\BulkParcelController@index')->middleware('auth');
    Route::GET('paid-parcel', 'Admin\ParcelController@paidParcel')->middleware('auth');
    Route::POST('bulk-parcel-import', 'Admin\BulkParcelController@getExcelToArray')->middleware('auth');
    Route::GET('update-order', 'Admin\ManageOrderController@updateOrderPage')->middleware('auth');
    Route::POST('update-order-awb', 'Admin\ManageOrderController@updateOrder')->middleware('auth');
    Route::patch('remove-consignment', 'Admin\ParcelController@removeConsignment')->middleware('auth');
//change-password
//guidelines
//support

});

Route::group(['middleware' => 'shogun'], function () {
    Route::get('/ShogunDashboard', 'Shogun\DashboardController@index')->name('ShogunDashboard')->middleware('auth');
    Route::get('/product-shogun', 'Shogun\ManageStockController@index')->name('manageStock')->middleware('auth', 'shogun');
    Route::get('/downline-shogun', 'Shogun\ManageDownlineController@index')->name('manageDownline')->middleware('auth');
    Route::get('/manageDownlineShogun/{role}/{id}', 'Shogun\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profile-shogun', 'Shogun\ProfileController@index')->middleware('auth');
    Route::POST('/profileShogun-update', 'Shogun\ProfileController@update')->name('profile.update.shogun')->middleware('auth');
    Route::POST('/change-password-shogun', 'Shogun\ProfileController@changePassword')->middleware('auth');
    Route::get('/shogun-cart', 'Shogun\CartController@cart')->middleware('auth');
    Route::get('/addToCartShogun/{id}', 'Shogun\CartController@addToCart')->middleware('auth');
    Route::patch('/update-cartShogun', 'Shogun\CartController@update')->middleware('auth');
    Route::delete('/remove-from-cartShogun', 'Shogun\CartController@remove')->middleware('auth');
    Route::POST('/checkout', 'Shogun\CartController@checkout')->middleware('auth');
    Route::get('/statusShogun', 'Shogun\CartController@paymentStatus')->name('statusShogun')->middleware('auth');
    Route::POST('/callbackShogun', 'Shogun\CartController@callback')->name('callbackShogun')->middleware('auth');
    Route::get('/purchase-history-shogun', 'Shogun\PurchaseController@index')->name('purchase-history')->middleware('auth');
    Route::get('/view-purchased-product/{orderID}', 'Shogun\PurchaseController@viewPurchase')->middleware('auth');
    Route::get('/customers-shogun', 'Shogun\CustomerController@index')->middleware('auth');
    Route::POST('/customers-shogun-add', 'Shogun\CustomerController@create')->middleware('auth');
    Route::POST('/customers-shogun-update', 'Shogun\CustomerController@update')->middleware('auth');
    Route::get('/customers-shogun-delete/{id}', 'Shogun\CustomerController@delete')->middleware('auth');
    Route::get('/commission-shogun', 'Shogun\CommissionController@index')->middleware('auth');
    Route::POST('/commission-shogun-withdrawal', 'Shogun\CommissionController@withdraw')->middleware('auth');
    Route::get('/approveDownline-shogun/{id}', 'Shogun\ManageDownlineController@approve')->middleware('auth');
    Route::get('/declineDownline-shogun/{id}', 'Shogun\ManageDownlineController@decline')->middleware('auth');
    Route::post('/addToPaymentCart-shogun', 'Shogun\CartController@addToPaymentCart')->middleware('auth');
    Route::delete('/remove-from-cart-payment-Shogun', 'Shogun\CartController@removeFromCartPayment')->middleware('auth');
    
//guideline-shogun
//support-shogun
});

Route::group(['middleware' => 'damio'], function () {
    
    Route::get('/DamioDashboard', 'Damio\DashboardController@index')->middleware('auth');
    Route::get('/product-damio', 'Damio\ManageStockController@index')->middleware('auth');
    Route::get('/downline-damio', 'Damio\ManageDownlineController@index')->middleware('auth');
    Route::get('/manageDownlineDamio/{role}/{id}', 'Damio\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profile-damio', 'Damio\ProfileController@index')->middleware('auth');
    Route::POST('/profileDamio-update', 'Damio\ProfileController@update')->middleware('auth');
    Route::POST('/change-password-damio', 'Damio\ProfileController@changePassword')->middleware('auth');
    Route::get('/damio-cart', 'Damio\CartController@cart')->middleware('auth');
    Route::get('/addToCartDamio/{id}', 'Damio\CartController@addToCart')->middleware('auth');
    Route::patch('/update-cartDamio', 'Damio\CartController@update')->middleware('auth');
    Route::delete('/remove-from-cartDamio', 'Damio\CartController@remove')->middleware('auth');
    Route::POST('/checkout-damio', 'Damio\CartController@checkout')->middleware('auth');
    Route::get('/statusDamio', 'Damio\CartController@paymentStatus')->middleware('auth');
    Route::POST('/callbackDamio', 'Damio\CartController@callback')->middleware('auth');
    Route::get('/purchase-history-damio', 'Damio\PurchaseController@index')->middleware('auth');
    Route::get('/view-purchased-product-damio/{orderID}', 'Damio\PurchaseController@viewPurchase')->middleware('auth');
    Route::get('/customers-damio', 'Damio\CustomerController@index')->middleware('auth');
    Route::POST('/customers-damio-add', 'Damio\CustomerController@create')->middleware('auth');
    Route::POST('/customers-damio-update', 'Damio\CustomerController@update')->middleware('auth');
    Route::get('/customers-damio-delete/{id}', 'Damio\CustomerController@delete')->middleware('auth');
    Route::get('/commission-damio', 'Damio\CommissionController@index')->middleware('auth');
    Route::POST('/commission-damio-withdrawal', 'Damio\CommissionController@withdraw')->middleware('auth');
    Route::get('/approveDownline-damio/{id}', 'Damio\ManageDownlineController@approve')->middleware('auth');
    Route::get('/declineDownline-damio/{id}', 'Damio\ManageDownlineController@decline')->middleware('auth');
    Route::post('/addToPaymentCart-damio', 'Damio\CartController@addToPaymentCart')->middleware('auth');
    Route::delete('/remove-from-cart-payment-Damio', 'Damio\CartController@removeFromCartPayment')->middleware('auth');
});

Route::group(['middleware' => 'merchant'], function () {
   
    Route::get('/MerchantDashboard', 'Merchant\DashboardController@index')->middleware('auth');
    Route::get('/product-merchant', 'Merchant\ManageStockController@index')->middleware('auth');
    Route::get('/downline-merchant', 'Merchant\ManageDownlineController@index')->middleware('auth');
    Route::get('/manageDownlineMerchant/{role}/{id}', 'Merchant\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profile-merchant', 'Merchant\ProfileController@index')->middleware('auth');
    Route::POST('/profileMerchant-update', 'Merchant\ProfileController@update')->middleware('auth');
    Route::POST('/change-password-merchant', 'Merchant\ProfileController@changePassword')->middleware('auth');
    Route::get('/merchant-cart', 'Merchant\CartController@cart')->middleware('auth');
    Route::get('/addToCartMerchant/{id}', 'Merchant\CartController@addToCart')->middleware('auth');
    Route::patch('/update-cartMerchant', 'Merchant\CartController@update')->middleware('auth');
    Route::delete('/remove-from-cartMerchant', 'Merchant\CartController@remove')->middleware('auth');
    Route::POST('/checkout-merchant', 'Merchant\CartController@checkout')->middleware('auth');
    Route::get('/statusMerchant', 'Merchant\CartController@paymentStatus')->middleware('auth');
    Route::POST('/callbackMerchant', 'Merchant\CartController@callback')->middleware('auth');
    Route::get('/purchase-history-merchant', 'Merchant\PurchaseController@index')->middleware('auth');
    Route::get('/view-purchased-product-merchant/{orderID}', 'Merchant\PurchaseController@viewPurchase')->middleware('auth');
    Route::get('/customers-merchant', 'Merchant\CustomerController@index')->middleware('auth');
    Route::POST('/customers-merchant-add', 'Merchant\CustomerController@create')->middleware('auth');
    Route::POST('/customers-merchant-update', 'Merchant\CustomerController@update')->middleware('auth');
    Route::get('/customers-merchant-delete/{id}', 'Merchant\CustomerController@delete')->middleware('auth');
    Route::get('/commission-merchant', 'Merchant\CommissionController@index')->middleware('auth');
    Route::POST('/commission-merchant-withdrawal', 'Merchant\CommissionController@withdraw')->middleware('auth');
    Route::get('/approveDownline-merchant/{id}', 'Merchant\ManageDownlineController@approve')->middleware('auth');
    Route::get('/declineDownline-merchant/{id}', 'Merchant\ManageDownlineController@decline')->middleware('auth');
    Route::post('/addToPaymentCart-merchant', 'Merchant\CartController@addToPaymentCart')->middleware('auth');
    Route::delete('/remove-from-cart-payment-Merchant', 'Merchant\CartController@removeFromCartPayment')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\DropshipMiddleware'], function () {
    Route::get('/DropshipDashboard', 'Dropship\DashboardController@index')->middleware('auth');
    Route::get('/product-dropship', 'Dropship\ManageStockController@index')->middleware('auth');
    Route::get('/profile-dropship', 'Dropship\ProfileController@index')->middleware('auth');
    Route::POST('/profileDropship-update', 'Dropship\ProfileController@update')->middleware('auth');
    Route::POST('/change-password-dropship', 'Dropship\ProfileController@changePassword')->middleware('auth');
    Route::get('/dropship-cart', 'Dropship\CartController@cart')->middleware('auth');
    Route::get('/addToCartDropship/{id}', 'Dropship\CartController@addToCart')->middleware('auth');
    Route::patch('/update-cartDropship', 'Dropship\CartController@update')->middleware('auth');
    Route::delete('/remove-from-cartDropship', 'Dropship\CartController@remove')->middleware('auth');
    Route::POST('/checkout-dropship', 'Dropship\CartController@checkout')->middleware('auth');
    Route::get('/statusDropship', 'Dropship\CartController@paymentStatus')->middleware('auth');
    Route::POST('/callbackDropship', 'Dropship\CartController@callback')->middleware('auth');
    Route::get('/purchase-history-dropship', 'Dropship\PurchaseController@index')->middleware('auth');
    Route::get('/view-purchased-product-dropship/{orderID}', 'Dropship\PurchaseController@viewPurchase')->middleware('auth');
    Route::get('/customers-dropship', 'Dropship\CustomerController@index')->middleware('auth');
    Route::POST('/customers-dropship-add', 'Dropship\CustomerController@create')->middleware('auth');
    Route::POST('/customers-dropship-update', 'Dropship\CustomerController@update')->middleware('auth');
    Route::get('/customers-dropship-delete/{id}', 'Dropship\CustomerController@delete')->middleware('auth');
    Route::get('/commission-dropship', 'Dropship\CommissionController@index')->middleware('auth');
    Route::POST('/commission-dropship-withdrawal', 'Dropship\CommissionController@withdraw')->middleware('auth');
    Route::post('/addToPaymentCart-dropship', 'Dropship\CartController@addToPaymentCart')->middleware('auth');
    Route::delete('/remove-from-cart-payment-Dropship', 'Dropship\CartController@removeFromCartPayment')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\MasterAdminMiddleware'], function () {
    Route::get('/MasterDashboard', 'MasterAdmin\DashboardController@index')->middleware('auth');
    Route::get('/master-viewAgent', 'MasterAdmin\ManageAgentController@index')->middleware('auth');
    Route::get('/master-commission', 'MasterAdmin\ManageCommissionController@index')->middleware('auth');
    Route::get('/master-commission-approve/{id}', 'MasterAdmin\ManageCommissionController@approve')->middleware('auth');
    Route::get('/master-commission-decline/{id}', 'MasterAdmin\ManageCommissionController@decline')->middleware('auth');
    Route::get('/profile-masteradmin', 'MasterAdmin\ProfileController@index')->middleware('auth');
    Route::POST('profile-update-masteradmin', 'MasterAdmin\ProfileController@update')->middleware('auth');
    Route::POST('change-password-masteradmin', 'MasterAdmin\ProfileController@changePassword')->middleware('auth');
    Route::get('/master-viewAgent-one/{id}', 'MasterAdmin\ManageAgentController@viewAgentProfile')->middleware('auth');
    Route::post('/product-create-master', 'MasterAdmin\ProductController@create')->middleware('auth');
    Route::post('/product-update-master', 'MasterAdmin\ProductController@update')->middleware('auth');
    Route::get('/master-manageProduct', 'MasterAdmin\ProductController@index')->middleware('auth');
    Route::get('/product-delete-master/{id}', 'MasterAdmin\ProductController@delete')->middleware('auth');
    Route::get('/master-manageAdmin', 'MasterAdmin\ManageAdminController@index')->middleware('auth');
    Route::get('/change-admin-type/{id}/{catID}', 'MasterAdmin\ManageAdminController@changeCategory')->middleware('auth');
    
});


Route::get('registerDownline/{id}', 'ReferralController@index');
// Route::get('registerDownline', 'ReferralController@page');
Route::POST('registerDownline', 'ReferralController@create');
Route::get('registerDownline-info', 'ReferralController@info');
