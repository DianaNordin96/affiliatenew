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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
   });
});

Auth::routes();


Route::group(['middleware' => 'admin'], function () {
    
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('auth', 'admin');

    Route::get('/manageAgent', 'Admin\ManageAgentController@index')->name('manageAgent')->middleware('auth');
    Route::POST('/manageAgent/create', 'Admin\ManageAgentController@create')->name('manageAgent.create')->middleware('auth');
    Route::POST('/manageAgent/update', 'Admin\ManageAgentController@update')->name('manageAgent.update')->middleware('auth');
    Route::get('/manageAgent/{role}/{id}', 'Admin\ManageAgentController@changeRole')->middleware('auth');
    Route::get('/manageProduct', 'Admin\ManageProductController@index')->name('manageProduct')->middleware('auth');
    Route::POST('/manageProduct/create', 'Admin\ManageProductController@create')->name('manageProduct.create')->middleware('auth');
    Route::POST('/manageProduct/store', 'Admin\ManageProductController@store')->name('purchase.store')->middleware('auth');
    Route::POST('/manageProduct/update', 'Admin\ManageProductController@update')->name('manageProduct.update')->middleware('auth');
    Route::get('view-order', 'Admin\ManageOrderController@index')->name('view-order')->middleware('auth');
});

Route::group(['middleware' => 'shogun'], function () {
   
    Route::get('/ShogunDashboard', 'Shogun\DashboardController@index')->name('ShogunDashboard')->middleware('auth');
    Route::get('/manageStockShogun', 'Shogun\ManageStockController@index')->name('manageStock')->middleware('auth', 'shogun');
    Route::get('/manageDownlineShogun', 'Shogun\ManageDownlineController@index')->name('manageDownline')->middleware('auth');
    Route::get('/manageDownlineShogun/{role}/{id}', 'Shogun\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profileShogun', 'Shogun\ProfileController@index')->middleware('auth');
    Route::POST('/profileShogun-update', 'Shogun\ProfileController@update')->name('profile.update.shogun')->middleware('auth');
    Route::get('shogun-cart', 'Shogun\CartController@cart');
    Route::get('addToCartShogun/{id}', 'Shogun\CartController@addToCart');
    Route::patch('update-cartShogun', 'Shogun\CartController@update');
    Route::delete('remove-from-cartShogun', 'Shogun\CartController@remove');
    Route::get('checkout', 'Shogun\CartController@checkout');
    Route::get('statusShogun', 'Shogun\CartController@paymentStatus')->name('statusShogun');
    Route::POST('callbackShogun', 'Shogun\CartController@callback')->name('callbackShogun');
    Route::get('purchase-historyShogun', 'Shogun\PurchaseController@index')->name('purchase-history')->middleware('auth');
    Route::get('view-purchased-product/{orderID}', 'Shogun\PurchaseController@viewPurchase')->middleware('auth');
});

Route::group(['middleware' => 'damio'], function () {
   
    Route::get('/DamioDashboard', 'Damio\DashboardController@index')->name('dashboard')->middleware('auth');
    Route::get('/manageStockDamio', 'Damio\ManageStockController@index')->name('manageStock')->middleware('auth');
    Route::get('/manageDownlineDamio', 'Damio\ManageDownlineController@index')->name('manageDownline')->middleware('auth');
    Route::get('/manageDownlineDamio/{role}/{id}', 'Damio\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profileDamio', 'Damio\ProfileController@index')->middleware('auth');
    Route::POST('/profileDamio-update', 'Damio\ProfileController@update')->name('profile.update.damio')->middleware('auth');
    Route::get('damio-cart', 'Damio\CartController@cart');
    Route::get('addToCartDamio/{id}', 'Damio\CartController@addToCart');
    Route::patch('update-cartDamio', 'Damio\CartController@update');
    Route::delete('remove-from-cartDamio', 'Damio\CartController@remove');
    Route::get('checkoutDamio', 'Damio\CartController@checkout');
    Route::get('statusDamio', 'Damio\CartController@paymentStatus')->name('statusDamio');
    Route::POST('callbackDamio', 'Damio\CartController@callback')->name('callbackDamio');
    Route::get('purchase-historyDamio', 'Damio\PurchaseController@index')->name('purchase-history')->middleware('auth');
    Route::get('view-purchased-productDamio/{orderID}', 'Damio\PurchaseController@viewPurchase')->middleware('auth');
});

Route::group(['middleware' => 'merchant'], function () {
   
    Route::get('/MerchantDashboard', 'Merchant\DashboardController@index')->name('dashboard')->middleware('auth');
    Route::get('/manageStockMerchant', 'Merchant\ManageStockController@index')->name('manageStock')->middleware('auth');
    Route::get('/manageDownlineMerchant', 'Merchant\ManageDownlineController@index')->name('manageDownline')->middleware('auth');
    Route::get('/manageDownlineMerchant/{role}/{id}', 'Merchant\ManageDownlineController@changeRole')->middleware('auth');
    Route::get('/profileMerchant', 'Merchant\ProfileController@index')->middleware('auth');
    Route::POST('/profileMerchant-update', 'Merchant\ProfileController@update')->name('profile.update.merchant')->middleware('auth');
    Route::get('merchant-cart', 'Merchant\CartController@cart');
    Route::get('addToCartMerchant/{id}', 'Merchant\CartController@addToCart');
    Route::patch('update-cartMerchant', 'Merchant\CartController@update');
    Route::delete('remove-from-cartMerchant', 'Merchant\CartController@remove');
    Route::get('checkoutMerchant', 'Merchant\CartController@checkout');
    Route::get('statusMerchant', 'Merchant\CartController@paymentStatus')->name('statusMerchant');
    Route::POST('callbackMerchant', 'Merchant\CartController@callback')->name('callbackMerchant');
    Route::get('purchase-historyMerchant', 'Merchant\PurchaseController@index')->middleware('auth');
    Route::get('view-purchased-productMerchant/{orderID}', 'Merchant\PurchaseController@viewPurchase')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\DropshipMiddleware'], function () {
    Route::get('/DropshipDashboard', 'Dropship\DashboardController@index')->name('dashboard')->middleware('auth');
});
