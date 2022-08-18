<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', [\App\Admin\Controllers\HomeController::class , 'index'])->name('home');

    $router->resource('cats', 'WorkshopCatController');
    $router->resource('menus', 'WorkshopProductController');
//    $router->post('menus/confirm1', 'TblOrderZMenuController@confirm1');
    $router->resource('groups', 'WorkshopGroupController');
    $router->resource('notices', 'NoticeController');
    $router->resource('forms', 'FormController');
    $router->resource('checks', 'WorkshopCheckController');
    $router->get('production_order', 'ProductionOrderController@index');
    $router->get('production_order/print', 'OrderPrintController@print')->name('admin.order_print');
    $router->get('production_order/print_rate', 'OrderPrintController@printByRate')->name('admin.order_print_rate');
    $router->patch('checks/update/{id}','WorkshopCheckController@updateChecks')->name('checkupdate');
    $router->resource('shopgroups', 'ShopGroupController');
    $router->resource('cart', 'WorkshopCartItemController');
    $router->resource('cartitem_log', 'WorkshopCartItemLogController');
    $router->resource('mypage', 'MypageController');

    //------------------------------------------------------------------
    //報告
    //分店每月銷售數量報告
    $router->resource('reports/total_sales_amount_by_menu', 'Reports\TotalSalesAmountByMenuReportController');
    //分店每月銷售總額報告
    $router->resource('reports/total_sales_by_group', 'Reports\TotalSalesByGroupReportController');
    //分店每月銷售總額報告(組合)
    $router->resource('reports/total_sales_by_group_combine', 'Reports\TotalSalesByGroupCombineReportController');
    //分店每月銷售總額報告(按日)
    $router->resource('reports/total_sales_by_day_combine', 'Reports\TotalSalesByDayCombineReportController');
    //分店銷售查詢
    $router->resource('reports/total_sales_by_search', 'Reports\TotalSalesBySearchReportController');

    //維修報表
    $router->resource('reports/repair_project', 'Reports\RepairProjectController');

    //會計相關
    //statement
    $router->get('reports/statement', 'Accountings\StatementController@index');
    $router->get('reports/statement/view', 'Accountings\StatementController@statement')->name('admin.statement.view');
    //invoice
    $router->get('reports/invoice', 'Accountings\InvoiceController@index');
    $router->get('reports/invoice/view', 'Accountings\InvoiceController@invoice')->name('admin.invoice.view');

    //營業數報告
    $router->resource('reports/sales_data_report', 'Reports\SalesDataReportController')->only(['index']);
    //營業數報告導出Excel
    $router->get('reports/export/sales_data_report', 'Reports\SalesDataReportController@export')->name('admin.export.sales_data_report');
    //營業數報告查看
    $router->get('reports/print/sales_data_report', 'Reports\SalesDataReportController@print')->name('admin.sales_data.print');

    //前台
    $router->resource('users', 'UserController');
    $router->resource('front/menu', 'MenuController');
    $router->resource('front/permissions', 'PermissionController');
    $router->resource('front/roles', 'RoleController');
    $router->resource('pages/front_users', 'UserController');

    //價格分組
    $router->resource('shopgroup', 'ShopGroupController');

    //前台用戶分組
    $router->resource('frontgroup', 'FrontGroupController');

    //api
    $router->get('api/group', 'ApiController@group');
    $router->get('api/group2', 'ApiController@group2');
    $router->get('api/cat', 'ApiController@cat');
    $router->get('api/unit', 'ApiController@unit');
    $router->get('api/shopgroup', 'ApiController@shop_group');

    //前台最近登錄用戶
    $router->get('lastlogin', 'LastLoginController@index');

    //圖書館
    $router->resource('library', 'Library\LibraryController');
    $router->resource('library_group', 'Library\LibraryGroupController');

    //員工
    $router->resource('employees', 'EmployeeController');

    //索償等級
    $router->resource('claim_levels', 'Claims\ClaimLevelController');
    $router->resource('claim_level_details', 'Claims\ClaimLevelDetailController');

    //索償
    $router->resource('claims', 'Claims\ClaimController');
    $router->resource('claim/report', 'Claims\ClaimReportController');

    //通知電郵設定
    $router->resource('notification_emails', 'NotificationEmailController');

    //CRM資料
    $router->resource('crm_datas', 'CrmDataController');

    //test
//    $router->get('data/', 'DataChangeController@index');
//    $router->put('data/test', 'DataChangeController@test');
//    $router->put('data/form', 'DataChangeController@changeForms');


});
