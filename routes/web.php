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
    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/order/select_day', 'OrderController@select_day')->name('select_day');
    Route::get('/order/select_old_order', 'OrderController@select_old_order')->name('order.select_old_order');
    Route::get('order/deli', 'OrderController@order_deli')->name('order.deli');
    Route::get('order/select_deli', 'OrderController@select_deli')->name('order.select_deli');
    Route::get('/order/select_rb_old_order', 'OrderController@select_rb_old_order')->name('rb.order.select_old_order');

    Route::get('order/cart','WorkshopCartItemController@cart')->name('cart');
    Route::post('order/cart/show_group/{catid}/{shopid}', 'WorkshopCartItemController@showGroup')->name('show_group');
    Route::post('order/cart/show_product/{groupid}/{shopid}', 'WorkshopCartItemController@showProduct')->name('show_product');
    Route::put('order/cart/{shopid}', 'WorkshopCartItemController@update')->name('cart.update');
});

Route::group(['middleware' => ['auth','permission:workshop']], function () {
    Route::get('order/deli/list', 'DeliController@list')->name('order.deli.list');
    Route::get('order/deli/edit', 'DeliController@deli_edit')->name('order.deli.edit');
    Route::post('order/deli/update', 'DeliController@deli_update')->name('deli.update');
});

//workshop分組
Route::group(['middleware' => ['auth','permission:workshop']], function () {
    Route::get('order/regular', 'Regular\RegularOrderController@index')->name('order.regular');
    Route::post('order/regular', 'Regular\RegularOrderController@store')->name('order.regular.store');

    Route::get('order/regular/sample', 'Regular\RegularOrderSampleController@index')->name('order.regular.sample');
    Route::get('order/regular/sample/create', 'Regular\RegularOrderSampleController@create')->name('order.regular.sample.create');
    Route::get('order/regular/sample/{sample}/edit', 'Regular\RegularOrderSampleController@edit')->name('order.regular.sample.edit');
    Route::post('order/regular/sample', 'Regular\RegularOrderSampleController@store')->name('order.regular.sample.store');
    Route::put('order/regular/sample/{sample}', 'Regular\RegularOrderSampleController@update')->name('order.regular.sample.update');
    Route::delete('order/regular/sample/{sample}', 'Regular\RegularOrderSampleController@destroy')->name('order.regular.sample.destroy');

    //臨時加單
    Route::get('order/regular/temp/create', 'Regular\TempOrderController@create')->name('order.regular.temp.create');
    Route::post('order/regular/temp', 'Regular\TempOrderController@store')->name('order.regular.temp.store');
    //外客
    Route::get('customer/select_customer_group', 'Customer\CustomerController@select_customer_group')->name('customer.select_group');
    Route::get('customer/order/select_old_order', 'Customer\CustomerController@select_old_order')->name('customer.order.select_old_order');

    Route::get('customer/order/cart','Customer\WorkshopCartItemController@cart')->name('customer.cart');
    Route::post('customer/order/cart/show_group/{catid}', 'Customer\WorkshopCartItemController@showGroup')->name('customer.show_group');
    Route::post('customer/order/cart/show_product/{groupid}', 'Customer\WorkshopCartItemController@showProduct')->name('customer.show_product');
    Route::put('customer/order/cart/{shopid}', 'Customer\WorkshopCartItemController@update')->name('customer.cart.update');
});

Route::group(['middleware' => ['auth','permission:shop']], function () {
    Route::get('sample', 'WorkshopOrderSampleController@index')->name('sample');
});

Route::group(['middleware' => ['auth','permission:operation']], function () {
    Route::get('sample/regular', 'WorkshopOrderSampleController@regular')->name('sample.regular');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('sample/create', 'WorkshopOrderSampleController@create')->name('sample.create');
    Route::get('sample/{sample}/edit', 'WorkshopOrderSampleController@edit')->name('sample.edit');
    Route::post('sample', 'WorkshopOrderSampleController@store')->name('sample.store');
    Route::put('sample/{sampleid}', 'WorkshopOrderSampleController@update')->name('sample.update');
    Route::delete('sample/{sampleid}', 'WorkshopOrderSampleController@destroy')->name('sample.destroy');

    Route::post('sample/show_group/{catid}/{shopid}', 'WorkshopOrderSampleController@showGroup')->name('sample.show_group');
    Route::post('sample/show_product/{groupid}/{shopid}', 'WorkshopOrderSampleController@showProduct')->name('sample.show_product');

    Route::get('support', 'SupportController@index')->name('support');

    Route::get('itsupport', 'ItSupportController@index')->name('itsupport');
    Route::post('itsupport', 'ItSupportController@store')->name('itsupport.store');
    Route::get('itsupport/{itsupport}/edit', 'ItSupportController@edit')->name('itsupport.edit');
    Route::get('itsupport/{itsupport}', 'ItSupportController@show')->name('itsupport.show');
    Route::patch('itsupport/{itsupportid}', 'ItSupportController@update')->name('itsupport.update');
    Route::delete('itsupport/{itsupport}', 'ItSupportController@destroy')->name('itsupport.destroy');

    Route::get('repair', 'RepairController@index')->name('repair');
    Route::post('repair', 'RepairController@store')->name('repair.store');
    Route::get('repair/{repair}/edit', 'RepairController@edit')->name('repair.edit');
    Route::get('repair/{repair}', 'RepairController@show')->name('repair.show');
    Route::patch('repair/{repairid}', 'RepairController@update')->name('repair.update');
    Route::delete('repair/{repair}', 'RepairController@destroy')->name('repair.destroy');

    Route::any('notice', 'NoticeController@index')->middleware('auth')->name('notice');
    Route::get('notice/attachment/{id}', 'NoticeController@attachment')->middleware('auth')->name('notice.attachment');
    Route::any('dept_form', 'FormController@index')->middleware('auth')->name('form');

    Route::get('addressbook', 'AddressBookController@index')->name('addressbook');

    //圖書館
    Route::get('library', 'Library\LibraryController@index')->name('library.index');
    Route::get('library/child/{id}', 'Library\LibraryController@child_index')->name('library.child.show');
    Route::any('library/search', 'Library\LibraryController@search')->name('library.search');

    Route::get('addressbook', 'AddressBookController@index')->name('addressbook');

    //通过redirect页面实现框架跳转
    Route::get('redirect/{message}', 'RedirectController@index')->name('redirect');

});

Route::get('stock', 'StockController@index')->name('stock.index');
Route::post('stock', 'StockController@index')->name('stock.search');
Route::post('stock/add', 'StockController@add')->name('stock.add');
Route::get('stock/supplier', 'SupplierStockController@index')->name('stock.supplier.index');

Route::group(['middleware' => ['auth','permission:workshop']], function () {
    Route::get('customer/sample/regular', 'Regular\CustomerRegularController@index')->name('customer.sample.index');
});

//Route::get('/import', 'ImportController@import');
//Route::get('/import/ryoyuprice', 'ImportController@importRyoyuPrice');
//Route::get('/import/newryoyuproductandprice', 'ImportController@importNewRyoyuProductAndPrice');
//Route::get('/import/customer', 'ImportController@importCustomer');
//Route::get('/import/reset/price', 'ImportController@resetPrice');
//Route::get('/import/customer/price', 'ImportController@importCustomerPrice');
//Route::get('/import/supplier', 'ImportController@importSupplierItems');
Route::get('/import/supplier/product', 'ImportController@importSupplierProduct');

//Route::get('/api/resetpassword', 'Api\ApiController@resetAllPassword');
//Route::get('/api/resetshoppassword', 'Api\ApiController@resetShopPassword');
//Route::get('/api/resetadminpassword', 'Api\ApiController@resetAdminAllPassword');

//datachange
//Route::get('/api/datachange/product_to_price', 'Api\DataChangeApiController@copyProductToPrice');

//test
//Route::get('/test', 'Regular\RegularOrderController@test');
