<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Api\Mobile\AuthController;


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
Route::get('/App_setting', 'App\Http\Controllers\Api\SettingController@Setting');
Route::get('/terms_condition', 'App\Http\Controllers\Api\SettingController@terms');


Route::get('/cities', 'App\Http\Controllers\Api\CityController@cities');
Route::get('/regions/{city_id}', 'App\Http\Controllers\Api\CityController@regions');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// delegate 
Route::prefix('v1')->namespace('App\Http\Controllers\Api')->group(function () {
    // auth apis 
    Route::post('/login','Mobile\AuthController@login');
    Route::post('/logout','Mobile\AuthController@logout');
    Route::post('/forget-password','Mobile\AuthController@forgetPassword');
    Route::post('/reset-password','Mobile\AuthController@resetPassword');
    
    // profiles
    Route::post('/profile/update','Mobile\ProfileController@update');
    Route::post('/change-password','Mobile\ProfileController@changePassword');
    Route::get('/user/statistics', 'Mobile\AuthController@analytics');
    Route::get('/balance', 'Mobile\ProfileController@balance');
    Route::post('/location', 'Mobile\AuthController@location');
    Route::post('/contact_us', 'Mobile\ProfileController@contact_us');

    // orders 
    Route::get('/orders', 'Mobile\OrderController@index');
    Route::get('/Daily/orders', 'Mobile\OrderController@Daily');

    Route::post('/orders/update', 'Mobile\OrderController@update');
    Route::post('/orders-list/update', 'Mobile\OrderController@updateList');
    Route::post('/orders-list-v2/update', 'Mobile\OrderController@updateListV2');
    Route::get('/statuses', 'Mobile\OrderController@statuses');
    Route::get('/search', 'Mobile\OrderController@search');
    Route::post('/orders/contact-count', 'Mobile\OrderController@contactCount');
    Route::get('/order/comments', 'Mobile\OrderController@comments');
    Route::post('/order/comment/store', 'Mobile\OrderController@storeComment');

 });
// 


// client
 Route::prefix('store/v1')->namespace('App\Http\Controllers\Api')->group(function () {

        
    Route::post('/login','Store\AuthController@login');
    Route::post('/logout','Store\AuthController@logout');
    Route::post('/forget-password','Store\AuthController@forgetPassword');
    Route::post('/reset-password','Store\AuthController@resetPassword');
    Route::post('/contact_us', 'Mobile\ProfileController@contact_us');

    
    // profiles
    Route::post('/profile/update','Store\ProfileController@update');
    Route::post('/change-password','Store\ProfileController@changePassword');
    Route::get('/user/statistics', 'Store\AuthController@analytics');
    Route::get('/balance', 'Store\ProfileController@balance');
    Route::get('/notifications', 'Store\ProfileController@notifications');
    Route::get('/notifications/{notification}', 'Store\ProfileController@notification_show');
    Route::get('/branches','Store\ProfileController@branches');


    
    Route::get('/order','Store\OrderController@index');
    Route::post('/order','Store\OrderController@store');
    Route::get('/search', 'Store\OrderController@search');
    Route::get('/Daily/orders', 'Store\OrderController@Daily');
    Route::get('/order_tracking','Store\OrderController@order_tracking');
    Route::post('/Resturant_order','Store\OrderController@Resturant_order');


});

