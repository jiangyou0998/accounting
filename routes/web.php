<?php

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



//Auth::routes();



Route::get('/', 'HomeController@index')
//    ->middleware('permission:visit_home')
//    ->middleware('guest')
    ->name('home');


// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => ['auth','permission:shop|workshop|operation']], function () {
    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/order/select_day', 'OrderController@select_day')->name('select_day');
    Route::get('order/deli', 'OrderController@order_deli')->name('order.deli');
    Route::get('order/select_deli', 'OrderController@select_deli')->name('order.select_deli');


    Route::get('order/cart','WorkshopCartItemController@cart')->name('cart');
    Route::post('order/cart/show_group/{catid}', 'WorkshopCartItemController@showGroup')->name('show_group');
    Route::post('order/cart/show_product/{groupid}', 'WorkshopCartItemController@showProduct')->name('show_product');
    Route::put('order/cart/{shopid}', 'WorkshopCartItemController@update')->name('cart.update');
});




Route::group(['middleware' => ['auth','permission:shop']], function () {
    Route::get('sample', 'WorkshopOrderSampleController@index')->name('sample');
    Route::get('sample/create', 'WorkshopOrderSampleController@create')->name('sample.create');
    Route::get('sample/{sample}/edit', 'WorkshopOrderSampleController@edit')->name('sample.edit');
    Route::post('sample', 'WorkshopOrderSampleController@store')->name('sample.store');
    Route::put('sample/{sampleid}', 'WorkshopOrderSampleController@update')->name('sample.update');
    Route::delete('sample/{sampleid}', 'WorkshopOrderSampleController@destroy')->name('sample.destroy');
});


Route::post('/sample/show_group/{catid}', 'WorkshopOrderSampleController@showGroup')->middleware('auth')->name('sample.show_group');
Route::post('/sample/show_product/{groupid}', 'WorkshopOrderSampleController@showProduct')->middleware('auth')->name('sample.show_product');
