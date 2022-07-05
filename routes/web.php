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


use App\Http\Controllers\SalesCalResultController;
use App\Http\Controllers\SalesDataChangeApplicationController;
use App\Http\Controllers\SalesDataController;

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

    //柯打首頁
    Route::get('/order', 'OrderController@index')->name('order');

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

Route::group(['middleware' => ['auth','permission:shop']], function () {
    Route::get('kb/sample', 'KB\KBWorkshopOrderSampleController@index')->name('kb.sample');

    // 銷售數據
    Route::get('sales_data', [SalesDataController::class, 'index'])->name('sales_data');
    Route::post('sales_data', [SalesDataController::class, 'store'])->name('sales_data.store');

    Route::get('sales_data_change_application', [SalesDataChangeApplicationController::class, 'index'])->name('sales_data_change_application.index');
    Route::post('sales_data_change_application', [SalesDataChangeApplicationController::class, 'store'])->name('sales_data_change_application.store');

    Route::get('sales_data/print', [SalesDataController::class, 'print'])->name('sales_data.print');
});

Route::group(['middleware' => ['auth','role:SuperAdmin|Operation']], function () {
    Route::get('sales_data/operation_index', [SalesDataController::class, 'operation_index'])->name('sales_data.operation_index');

    Route::get('sales_data_change_application/apply_index', [SalesDataChangeApplicationController::class, 'apply_index'])->name('sales_data_change_application.apply_index');
    Route::post('sales_data_change_application/apply', [SalesDataChangeApplicationController::class, 'apply'])->name('sales_data_change_application.apply');


//    新增營業數記錄
    Route::get('sales_data/sales_cal_results/create', [SalesCalResultController::class, 'create'])->name('sales_data.sales_cal_results.create');
    Route::post('sales_data/sales_cal_results/check', [SalesCalResultController::class, 'check'])->name('sales_data.sales_cal_results.check');
    Route::post('sales_data/sales_cal_results', [SalesCalResultController::class, 'store'])->name('sales_data.sales_cal_results.store');
});

Route::group(['middleware' => ['auth']], function () {

    //蛋撻王工場範本
    Route::get('kb/sample/create', 'KB\KBWorkshopOrderSampleController@create')->name('kb.sample.create');
    Route::get('kb/sample/{sample}/edit', 'KB\KBWorkshopOrderSampleController@edit')->name('kb.sample.edit');
    Route::post('kb/sample', 'KB\KBWorkshopOrderSampleController@store')->name('kb.sample.store');
    Route::put('kb/sample/{sampleid}', 'KB\KBWorkshopOrderSampleController@update')->name('kb.sample.update');
    Route::delete('kb/sample/{sampleid}', 'KB\KBWorkshopOrderSampleController@destroy')->name('kb.sample.destroy');

    Route::post('kb/sample/show_group/{catid}', 'KB\KBWorkshopOrderSampleController@showGroup')->name('kb.sample.show_group');
    Route::post('kb/sample/show_product/{groupid}', 'KB\KBWorkshopOrderSampleController@showProduct')->name('kb.sample.show_product');

    //HR
    //醫療索償
    Route::get('claim', 'ClaimController@index')->name('claim');
    Route::post('claim', 'ClaimController@store')->name('claim.store');
    Route::post('claim/message', 'ClaimController@claimMessage')->name('claim.message');

    //報告
    Route::get('support', 'SupportController@index')->name('support');

    //IT維修報告
    Route::get('itsupport', 'ItSupportController@index')->name('itsupport');
    Route::post('itsupport', 'ItSupportController@store')->name('itsupport.store');
    Route::get('itsupport/{itsupport}/edit', 'ItSupportController@edit')->name('itsupport.edit');
    Route::get('itsupport/{itsupport}', 'ItSupportController@show')->name('itsupport.show');
    Route::patch('itsupport/{itsupportid}', 'ItSupportController@update')->name('itsupport.update');
    Route::delete('itsupport/{itsupport}', 'ItSupportController@destroy')->name('itsupport.destroy');

    Route::get('phone/itsupport', 'ItSupportController@phoneIndex')->name('itsupport.phone');

    //維修報告
    Route::get('repair', 'RepairController@index')->name('repair');
    Route::post('repair', 'RepairController@store')->name('repair.store');
    Route::get('repair/{repair}/edit', 'RepairController@edit')->name('repair.edit');
    Route::get('repair/{repair}', 'RepairController@show')->name('repair.show');
    Route::patch('repair/{repairid}', 'RepairController@update')->name('repair.update');
    Route::delete('repair/{repair}', 'RepairController@destroy')->name('repair.destroy');

    Route::get('repair_order', 'RepairOrderController@index')->name('repair_order');
    Route::post('repair_order', 'RepairOrderController@store')->name('repair_order.store');

    Route::get('phone/repair', 'RepairController@phoneIndex')->name('repair.phone');
    Route::get('phone/repair/{shop_id}', 'RepairController@phoneView')->name('repair.phone.view');

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
//Route::get('/import/employee', 'Import\EmployeeImportController@import');
//Route::get('/importryoyuprice', 'ImportController@importRyoyuPrice');
//Route::get('/api/resetpassword', 'Api\ApiController@resetAllPassword');
//Route::get('/api/resetshoppassword', 'Api\ApiController@resetShopPassword');
//Route::get('/api/resetadminpassword', 'Api\ApiController@resetAdminAllPassword');

//datachange
//Route::get('/api/datachange/product_to_price', 'Api\DataChangeApiController@copyProductToPrice');





