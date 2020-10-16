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


Auth::routes();


Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
    Route::get('/', function () {
       
              return redirect('/dashboard');
    });
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('auth');

    Route::get('/manageAgent', 'Admin\ManageAgentController@index')->name('manageAgent')->middleware('auth');
    Route::POST('/manageAgent/create', 'Admin\ManageAgentController@create')->name('manageAgent.create')->middleware('auth');
    Route::POST('/manageAgent/update', 'Admin\ManageAgentController@update')->name('manageAgent.update')->middleware('auth');
    Route::get('/manageAgent/{role}/{id}', 'Admin\ManageAgentController@changeRole')->middleware('auth');

    Route::get('/manageProduct', 'Admin\ManageProductController@index')->name('manageProduct')->middleware('auth');
    Route::POST('/manageProduct/create', 'Admin\ManageProductController@create')->name('manageProduct.create')->middleware('auth');
    Route::POST('/manageProduct/store', 'Admin\ManageProductController@store')->name('purchase.store')->middleware('auth');
    // Route::POST('/manageProduct/update', 'Admin\ManageProductController@update')->name('manageAgent.update')->middleware('auth');
    // Route::get('/manageProduct/{role}/{id}', 'Admin\ManageProductController@changeRole')->middleware('auth');


});

Route::group(['middleware' => 'App\Http\Middleware\ShogunMiddleware'], function () {
    Route::get('/', function () {
        
        return redirect('/ShogunDashboard');
    });
    Route::get('/ShogunDashboard', 'Shogun\DashboardController@index')->name('dashboard')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\DamioMiddleware'], function () {
    Route::get('/DamioDashboard', 'Damyu\DashboardController@index')->name('dashboard')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\MerchantMiddleware'], function () {
    Route::get('/MerchantDashboard', 'Merchant\DashboardController@index')->name('dashboard')->middleware('auth');
});

Route::group(['middleware' => 'App\Http\Middleware\DropshipMiddleware'], function () {
    Route::get('/DropshipDashboard', 'Dropship\DashboardController@index')->name('dashboard')->middleware('auth');
});


Route::get('/unauthorized', 'UnauthorizedController@index')->name('unauthorized');
