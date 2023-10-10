<?php

use App\Http\Controllers\Admin\HomeController;


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


Route::webhooks('salla-webhook','salla');
Route::webhooks('foodics-webhook','foodics');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{


    Route::get('/', 'App\Http\Controllers\Website\HomeController@index')->name('home');
    Route::get('/send-request', 'App\Http\Controllers\Website\HomeController@feedback')->name('feedback.index');
    Route::post('/send-request', 'App\Http\Controllers\Website\HomeController@feedbackSubmit')->name('feedback.store');
    Route::get('/about-us', 'App\Http\Controllers\Website\HomeController@about')->name('about');
    Route::get('/contact-us', 'App\Http\Controllers\Website\HomeController@contact')->name('contact');
    Route::post('/contact-us', 'App\Http\Controllers\Website\HomeController@contactSubmit')->name('contact.store');
    Route::get('/request-join', 'App\Http\Controllers\Website\HomeController@requestJoin')->name('join');
    Route::post('/request-join', 'App\Http\Controllers\Website\HomeController@requestJoinSubmit')->name('join.store');
    Route::get('/blog', 'App\Http\Controllers\Website\BlogController@index')->name('blog.index');
    Route::get('/blog/{post}', 'App\Http\Controllers\Website\BlogController@show')->name('blog.show');
    Route::get('/track', 'App\Http\Controllers\Website\HomeController@tracking')->name('track.order');
    Route::get('print-order' , 'App\Http\Controllers\Website\HomeController@printOrder')->name('print.order');

    Route::get('/order/rate/{key}/{mobile}', 'App\Http\Controllers\Website\HomeController@rate_order')->name('rate.order');
    Route::post('/order/rate/{key}/{mobile}', 'App\Http\Controllers\Website\HomeController@post_rate_order')->name('post-rate.order');
    Route::get('/order/rates'              , 'App\Http\Controllers\Website\HomeController@list_rate_order')->name('list-rate.order');


    Route::middleware(['auth', 'client'])->prefix('client')->group(function () {
        Route::get('/', 'App\Http\Controllers\Client\HomeController@index')->name('client.dashboard');
        Route::get('/terms', 'App\Http\Controllers\Client\TremsController@index')->name('terms.show');
        Route::post('/terms/agree', 'App\Http\Controllers\Client\TremsController@agree')->name('terms.agree');
        Route::resource('/addresses', 'App\Http\Controllers\Client\AddressController');
        Route::resource('/orders'               , 'App\Http\Controllers\Client\OrderController');
        Route::post('/place_order_excel'        , 'App\Http\Controllers\Client\OrderController@placeـorder_excel_to_db');


        Route::get('/order/history/{order}', 'App\Http\Controllers\Client\OrderController@history')
            ->name('order.history');
        Route::post('/ordersRes/store'        , 'App\Http\Controllers\Client\OrderController@res_store');



        Route::put('/order-print-invoice', 'App\Http\Controllers\Client\OrderController@print_invoices')
            ->name('order.print-invoice');

        Route::get('/transactions', 'App\Http\Controllers\Client\HomeController@transactions')
            ->name('transactions.client');
        Route::get('/order-notifications/{key}', 'App\Http\Controllers\NotificationController@order_notification')->name('client.order-notification');
    });




    // /order-notification


    Route::get('/notifications', '\App\Http\Controllers\NotificationController@index')->name('notifications.index');
    Route::POST('/notifications', '\App\Http\Controllers\NotificationController@store')->name('notifications.store');
    Route::get('/notifications/{notification}', '\App\Http\Controllers\NotificationController@show')->name('notifications.show');
    Route::put('/notifications/{notification}/unread', '\App\Http\Controllers\NotificationController@unread')->name('notifications.unread');

});


Auth::routes(['register' => false]);

Route::get('/profile', '\App\Http\Controllers\ProfileController@edit')->name('profile.edit');
Route::put('/profile/{user}', '\App\Http\Controllers\ProfileController@update')->name('profile.update');
Route::get('/getregions/{id}', '\App\Http\Controllers\HomeController@getregions')->name('regions.city');
Route::get('/getclient/{id}', '\App\Http\Controllers\HomeController@getclient')->name('regions.city');




Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', '\App\Http\Controllers\Admin\HomeController@index')->name('admin.dashboard');
    Route::resource('/cities', '\App\Http\Controllers\Admin\CityController');
    Route::resource('/regions', '\App\Http\Controllers\Admin\RegionsController');
    Route::get('/regions/city/{id}', '\App\Http\Controllers\Admin\RegionsController@city')->name('regions.city');
    Route::get('/getregions/{id}', '\App\Http\Controllers\Admin\RegionsController@getregions');
    Route::resource('/DailyReport', '\App\Http\Controllers\Admin\DailyReportController');





    Route::resource('/statuses', '\App\Http\Controllers\Admin\StatusController');


    Route::resource('/rate_orders', '\App\Http\Controllers\Admin\RateOrderController');
    Route::post('/delegate_appear', '\App\Http\Controllers\Admin\StatusController@change_delegate_appear');
    Route::post('/client_appear', '\App\Http\Controllers\Admin\StatusController@change_client_appear');
        Route::post('/restaurant_appear', '\App\Http\Controllers\Admin\StatusController@change_restaurant_appear');
    Route::post('/shop_appear', '\App\Http\Controllers\Admin\StatusController@change_shop_appear');


    Route::get('/clients/api', '\App\Http\Controllers\Admin\ClientController@api')
    ->name('clients.api');
    Route::POST('/clients/api', '\App\Http\Controllers\Admin\ClientController@apiStore')
    ->name('clients-api.store');
    Route::DELETE('/clients/api/{id}', '\App\Http\Controllers\Admin\ClientController@apiDestroy')
    ->name('clients-api.destroy');
    Route::resource('/clients', '\App\Http\Controllers\Admin\ClientController');
    Route::get('/clients/address/{id}', '\App\Http\Controllers\Admin\ClientController@addresses');
    Route::get('/clients/address_store/{id}', '\App\Http\Controllers\Admin\ClientController@address_create');
    Route::get('/clients/address_delete/{id}', '\App\Http\Controllers\Admin\ClientController@address_delete');


    Route::get('/clients/address_edit/{id}', '\App\Http\Controllers\Admin\ClientController@address_edit');
        Route::post('/clients/address_edit/{id}', '\App\Http\Controllers\Admin\ClientController@address_update');


    Route::post('/clients/address_store', '\App\Http\Controllers\Admin\ClientController@address_store');



    Route::get('/balances', '\App\Http\Controllers\Admin\ClientController@balances')
    ->name('clients.balances');
    Route::get('/balances/transactions/{client}', '\App\Http\Controllers\Admin\ClientController@transactions')
    ->name('clients.transactions');

    Route::POST('/balances/transactions', '\App\Http\Controllers\Admin\ClientController@transactionStore')
    ->name('transaction.store');
    Route::delete('/balances/transactions/{transaction}', '\App\Http\Controllers\Admin\ClientController@transactionDestroy')
    ->name('transaction.destroy');
    //delegates
    Route::get('/delegates/balances', '\App\Http\Controllers\Admin\DelegateController@balances')
    ->name('delegates.balances');
    Route::get('/delegates/tracking', '\App\Http\Controllers\Admin\DelegateController@tracking')
    ->name('delegates.tracking');
    Route::get('/delegates/orders/{delegate}', '\App\Http\Controllers\Admin\DelegateController@orders')->name('delegates.orders');
    Route::get('/delegates/balances/transactions/{id}', '\App\Http\Controllers\Admin\DelegateController@transactions')
    ->name('delegates.transactions');
    Route::resource('/delegates', '\App\Http\Controllers\Admin\DelegateController');
    //
    Route::resource('/sliders', '\App\Http\Controllers\Admin\SliderController');
    Route::resource('/services', '\App\Http\Controllers\Admin\ServiceController');
    Route::resource('/what-we-do', '\App\Http\Controllers\Admin\WhatWeDoController');
    Route::resource('/posts', '\App\Http\Controllers\Admin\PostController');
    Route::resource('/pages', '\App\Http\Controllers\Admin\PageController');
    Route::resource('/branches', '\App\Http\Controllers\Admin\BranchController');
    Route::resource('/categories', '\App\Http\Controllers\Admin\CategoryController');
    Route::resource('/contacts', '\App\Http\Controllers\Admin\ContactController');
    Route::resource('/feedbacks', '\App\Http\Controllers\Admin\FeedbackController');
    Route::resource('/request-joins', '\App\Http\Controllers\Admin\RequestJoinController');
    Route::resource('/client-orders', '\App\Http\Controllers\Admin\OrderController');
    Route::resource('/roles', '\App\Http\Controllers\Admin\RoleController');
    Route::resource('/users', '\App\Http\Controllers\Admin\UserController');
    Route::get('/client-orders/history/{order}', '\App\Http\Controllers\Admin\OrderController@history')
    ->name('client-orders.history');
    //

    Route::resource('/report', '\App\Http\Controllers\Admin\ReportController');
    Route::get('/report/invoice/{order}', '\App\Http\Controllers\Admin\ReportController@invoice')
    ->name('report.invoice');

    Route::get('generate/pdf/{id}', '\App\Http\Controllers\Admin\ReportController@generate');
    Route::get('reportpdf/{id}', '\App\Http\Controllers\Admin\ReportController@reportpdf');







    //
    Route::get('/categories/confirm/{category}', '\App\Http\Controllers\Admin\CategoryController@confirm')
    ->name('categories.confirm');
    Route::get('/settings', '\App\Http\Controllers\Admin\WebSettingController@edit')
    ->name('settings.edit');
    Route::Put('/settings/update', '\App\Http\Controllers\Admin\WebSettingController@update')
    ->name('settings.update');
    Route::get('/app/settings', '\App\Http\Controllers\Admin\SettingController@edit')
    ->name('appSettings.edit');
    Route::Put('/app/settings/update', '\App\Http\Controllers\Admin\SettingController@update')
    ->name('appSettings.update');

    Route::Put('/orders/distribute', '\App\Http\Controllers\Admin\OrderController@distribute')
        ->name('order.distribute');
        Route::get('/orders/type2/', '\App\Http\Controllers\Admin\OrderController@index2')->name('client-orders.index2');

    Route::put('/orders/change_status/', '\App\Http\Controllers\Admin\OrderController@change_status')->name('order.change_status');
    Route::get('/order-notifications/{key}', '\App\Http\Controllers\NotificationController@order_notification')->name('notifications.order-notification');
    Route::get('/orders/makeReturn/{order}', '\App\Http\Controllers\Admin\OrderController@createReturnOrder')->name('order.return');


    Route::get('/orders/comments/{id}', '\App\Http\Controllers\Admin\CommentController@index')->name('comments.index');
    Route::POST('/orders/comment/', '\App\Http\Controllers\Admin\CommentController@store')->name('comments.store');
    Route::DELETE('/orders/comments/{id}', '\App\Http\Controllers\Admin\CommentController@destroy')->name('comments.destroy');
});

Route::middleware(['auth', 'delegate'])->prefix('delegate')->group(function () {
    Route::get('/', 'App\Http\Controllers\Delegate\HomeController@index')->name('delegate.dashboard');
    Route::resource('/delegate-orders', 'App\Http\Controllers\Delegate\OrderController');
    Route::get('/transactions', 'App\Http\Controllers\Delegate\HomeController@transactions')->name('transactions.delegate');
    Route::get('/order/comments/{id}', 'App\Http\Controllers\Delegate\CommentController@index')->name('myOrder.comments');
    Route::POST('/order/comment', 'App\Http\Controllers\Delegate\CommentController@store')->name('myComment.store');
        Route::resource('/DayReport', 'App\Http\Controllers\Delegate\DayReportController');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
