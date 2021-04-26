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
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('password/resetlogin', 'Auth\ResetPasswordLoginedController@showResetForm')->name('password.reset.login')->middleware('auth');
Route::post('password/resetlogin', 'Auth\ResetPasswordLoginedController@reset')->name('password.update.login')->middleware('auth');

// Email 认证相关路由
//Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
//Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::group(['middleware' => ['auth','permission:shop|workshop|operation']], function () {
    //糧友工場
    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/order/select_day', 'OrderController@select_day')->name('select_day');
    Route::get('/order/select_old_order', 'OrderController@select_old_order')->name('order.select_old_order');
    Route::get('order/deli', 'OrderController@order_deli')->name('order.deli');
    Route::get('order/select_deli', 'OrderController@select_deli')->name('order.select_deli');

    Route::get('order/cart','WorkshopCartItemController@cart')->name('cart');
    Route::post('order/cart/show_group/{catid}', 'WorkshopCartItemController@showGroup')->name('show_group');
    Route::post('order/cart/show_product/{groupid}', 'WorkshopCartItemController@showProduct')->name('show_product');
    Route::put('order/cart/{shopid}', 'WorkshopCartItemController@update')->name('cart.update');

    //蛋撻王工場
    Route::get('kb/order/select_day', 'KB\KBOrderController@select_day')->name('kb.select_day');
    Route::get('kb/order/select_old_order', 'KB\KBOrderController@select_old_order')->name('kb.order.select_old_order');
    Route::get('kb/order/deli', 'KB\KBOrderController@order_deli')->name('kb.order.deli');
    Route::get('kb/order/select_deli', 'KB\KBOrderController@select_deli')->name('kb.order.select_deli');

    Route::get('kb/order/cart','KB\KBWorkshopCartItemController@cart')->name('kb.cart');
    Route::post('kb/order/cart/show_group/{catid}', 'KB\KBWorkshopCartItemController@showGroup')->name('kb.show_group');
//    Route::post('kb/order/cart/show_product/{groupid}', 'KB\KBWorkshopCartItemController@showProduct')->name('kb.show_product');
    Route::post('kb/order/cart/show_product/{groupid}/{shopid}', 'KB\KBWorkshopCartItemController@showProduct')->name('kb.show_product');
    Route::put('kb/order/cart/{shopid}', 'KB\KBWorkshopCartItemController@update')->name('kb.cart.update');

});

Route::group(['middleware' => ['auth','permission:shop|operation']], function () {
    Route::get('order/deli/edit', 'DeliController@deli_edit')->name('order.deli.edit');
    Route::post('order/deli/update', 'DeliController@deli_update')->name('deli.update');
});

Route::group(['middleware' => ['auth','permission:operation']], function () {
    Route::get('order/deli/list', 'DeliController@list')->name('order.deli.list');

});

Route::group(['middleware' => ['auth','permission:operation']], function () {
    Route::get('order/regular', 'RegularOrderController@index')->name('order.regular');
    Route::post('order/regular', 'RegularOrderController@store')->name('order.regular.store');
});

Route::group(['middleware' => ['auth','permission:shop']], function () {
    Route::get('sample', 'WorkshopOrderSampleController@index')->name('sample');
    Route::get('kb/sample', 'KB\KBWorkshopOrderSampleController@index')->name('kb.sample');
});

Route::group(['middleware' => ['auth','permission:operation']], function () {
    Route::get('sample/regular', 'WorkshopOrderSampleController@regular')->name('sample.regular');
});

Route::group(['middleware' => ['auth']], function () {
    //範本
    Route::get('sample/create', 'WorkshopOrderSampleController@create')->name('sample.create');
    Route::get('sample/{sample}/edit', 'WorkshopOrderSampleController@edit')->name('sample.edit');
    Route::post('sample', 'WorkshopOrderSampleController@store')->name('sample.store');
    Route::put('sample/{sampleid}', 'WorkshopOrderSampleController@update')->name('sample.update');
    Route::delete('sample/{sampleid}', 'WorkshopOrderSampleController@destroy')->name('sample.destroy');

    Route::post('sample/show_group/{catid}', 'WorkshopOrderSampleController@showGroup')->name('sample.show_group');
    Route::post('sample/show_product/{groupid}', 'WorkshopOrderSampleController@showProduct')->name('sample.show_product');

    //蛋撻王工場範本
    Route::get('kb/sample/create', 'KB\KBWorkshopOrderSampleController@create')->name('kb.sample.create');
    Route::get('kb/sample/{sample}/edit', 'KB\KBWorkshopOrderSampleController@edit')->name('kb.sample.edit');
    Route::post('kb/sample', 'KB\KBWorkshopOrderSampleController@store')->name('kb.sample.store');
    Route::put('kb/sample/{sampleid}', 'KB\KBWorkshopOrderSampleController@update')->name('kb.sample.update');
    Route::delete('kb/sample/{sampleid}', 'KB\KBWorkshopOrderSampleController@destroy')->name('kb.sample.destroy');

    Route::post('kb/sample/show_group/{catid}', 'KB\KBWorkshopOrderSampleController@showGroup')->name('kb.sample.show_group');
    Route::post('kb/sample/show_product/{groupid}', 'KB\KBWorkshopOrderSampleController@showProduct')->name('kb.sample.show_product');

    //報告
    Route::get('support', 'SupportController@index')->name('support');

    //IT維修報告
    Route::get('itsupport', 'ItSupportController@index')->name('itsupport');
    Route::post('itsupport', 'ItSupportController@store')->name('itsupport.store');
    Route::get('itsupport/{itsupport}/edit', 'ItSupportController@edit')->name('itsupport.edit');
    Route::get('itsupport/{itsupport}', 'ItSupportController@show')->name('itsupport.show');
    Route::patch('itsupport/{itsupportid}', 'ItSupportController@update')->name('itsupport.update');
    Route::delete('itsupport/{itsupport}', 'ItSupportController@destroy')->name('itsupport.destroy');

    //維修報告
    Route::get('repair', 'RepairController@index')->name('repair');
    Route::post('repair', 'RepairController@store')->name('repair.store');
    Route::get('repair/{repair}/edit', 'RepairController@edit')->name('repair.edit');
    Route::get('repair/{repair}', 'RepairController@show')->name('repair.show');
    Route::patch('repair/{repairid}', 'RepairController@update')->name('repair.update');
    Route::delete('repair/{repair}', 'RepairController@destroy')->name('repair.destroy');

    //通告
    Route::any('notice', 'NoticeController@index')->middleware('auth')->name('notice');
    Route::get('notice/attachment/{id}', 'NoticeController@attachment')->middleware('auth')->name('notice.attachment');
    //表格
    Route::any('dept_form', 'FormController@index')->middleware('auth')->name('form');

    //通訊錄
    Route::get('addressbook', 'AddressBookController@index')->name('addressbook');

    //圖書館
    Route::get('library', 'Library\LibraryController@index')->name('library.index');
    Route::get('library/child/{id}', 'Library\LibraryController@child_index')->name('library.child.show');
    Route::any('library/search', 'Library\LibraryController@search')->name('library.search');

    //收貨
    Route::get('delivery', 'DeliveryController@index')->name('delivery');

    //通过redirect页面实现框架跳转
    Route::get('redirect/{message}', 'RedirectController@index')->name('redirect');

});



//Route::get('/import', 'ImportController@import');
//Route::get('/importryoyuprice', 'ImportController@importRyoyuPrice');
//Route::get('/api/resetpassword', 'Api\ApiController@resetAllPassword');
//Route::get('/api/resetshoppassword', 'Api\ApiController@resetShopPassword');
//Route::get('/api/resetadminpassword', 'Api\ApiController@resetAdminAllPassword');

//datachange
//Route::get('/api/datachange/product_to_price', 'Api\DataChangeApiController@copyProductToPrice');





