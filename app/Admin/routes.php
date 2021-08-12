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
    $router->get('production_order', 'ProductionOrderController@index')->name('admin.production_order');
    $router->get('production_order/print', 'OrderPrintController@print')->name('admin.order_print');
//    $router->get('production_order/printCheck', 'OrderPrintController@printCheck')->name('admin.order_print.check');
    $router->post('checks/create','WorkshopCheckController@createChecks')->name('checkcreate');
    $router->patch('checks/update/{id}','WorkshopCheckController@updateChecks')->name('checkupdate');
    $router->resource('shopgroups', 'ShopGroupController');
    $router->resource('cart', 'WorkshopCartItemController');
    $router->resource('cartitem_log', 'WorkshopCartItemLogController');
    $router->resource('mypage', 'MypageController');
    $router->resource('special_date', 'SpecialDateController');
    $router->resource('forbidden_date', 'ForbiddenDateController');
//    $router->resource('report', 'ReportController');

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
    //每月庫存報告
    $router->resource('reports/stock_by_month', 'Reports\StockByMonthReportController');

    //會計相關
    //statement
    $router->get('reports/statement', 'Accountings\StatementController@index');
    $router->get('reports/statement/view', 'Accountings\StatementController@statement')->name('admin.statement.view');
    //invoice
    $router->get('reports/invoice', 'Accountings\InvoiceController@index');
    //外客invoice首頁
    $router->get('reports/invoice/customer', 'Accountings\CustomerInvoiceController@index');
    $router->get('reports/invoice/view', 'Accountings\InvoiceController@invoice')->name('admin.invoice.view');
    $router->get('reports/delivery/view', 'Accountings\InvoiceController@delivery')->name('admin.delivery.view');

    //前台
    $router->resource('users', 'UserController');
    $router->resource('front/menu', 'MenuController');
    $router->resource('front/permissions', 'PermissionController');
    $router->resource('front/roles', 'RoleController');
    $router->resource('front/shop_groups', 'ShopGroupController');
    $router->resource('pages/front_users', 'UserController');

    //供應商
    $router->resource('suppliers', 'SupplierController');
    //供應商產品
    $router->resource('supplier_products', 'SupplierProductController');
    //
    $router->resource('supplier_stock_items', 'SupplierStockItemController');
    //
    $router->resource('supplier_stock_item_list', 'SupplierStockItemListController');

    //價格分組
    $router->resource('shopgroup', 'ShopGroupController');
    //分店用戶管理
    $router->resource('shopusers', 'ShopUserController');

    //前台用戶分組
    $router->resource('frontgroup', 'FrontGroupController');


    //價格查詢
    $router->resource('prices', 'PriceController');

    //api
    $router->get('api/group', 'ApiController@group');
    $router->get('api/group2', 'ApiController@group2');
    $router->get('api/cat', 'ApiController@cat');
    $router->get('api/unit', 'ApiController@unit');
    $router->get('api/shopgroup', 'ApiController@shop_group');

    //圖書館
    $router->resource('library', 'Library\LibraryController');
    $router->resource('library_group', 'Library\LibraryGroupController');

    //前台最近登錄用戶
    $router->get('lastlogin', 'LastLoginController@index');

    //test
//    $router->get('data/', 'DataChangeController@index');
//    $router->put('data/test', 'DataChangeController@test');
//    $router->put('data/form', 'DataChangeController@changeForms');

//    $router->resource('menus2', 'WorkshopProductExportController');


//    $router->get('test',function (){
//       return view('admin.checks.layout');
//    });

});
