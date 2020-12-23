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
    $router->resource('groups', 'TblOrderZGroupController');
    $router->resource('notices', 'NoticeController');
    $router->resource('forms', 'FormController');
    $router->resource('checks', 'WorkshopCheckController');
    $router->get('production_order', 'ProductionOrderController@index');
    $router->get('production_order/print', 'OrderPrintController@print')->name('admin.order_print');
//    $router->get('production_order/printCheck', 'OrderPrintController@printCheck')->name('admin.order_print.check');
    $router->post('checks/create','WorkshopCheckController@createChecks')->name('checkcreate');
    $router->patch('checks/update/{id}','WorkshopCheckController@updateChecks')->name('checkupdate');
    $router->resource('shopgroups', 'ShopGroupController');
    $router->resource('cart', 'WorkshopCartItemController');
    $router->resource('cartitem_log', 'WorkshopCartItemLogController');
    $router->resource('mypage', 'MypageController');
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


    //前台
    $router->resource('users', 'UserController');
    $router->resource('front/menu', 'MenuController');
    $router->resource('front/permissions', 'PermissionController');
    $router->resource('front/roles', 'RoleController');
    $router->resource('pages/front_users', 'UserController');

    //商店分組
    $router->resource('shopgroup', 'ShopGroupController');

    //api
    $router->get('api/group', 'ApiController@group');
    $router->get('api/group2', 'ApiController@group2');
    $router->get('api/cat', 'ApiController@cat');
    $router->get('api/unit', 'ApiController@unit');
    $router->get('api/shopgroup', 'ApiController@shop_group');

    //test
//    $router->get('data/', 'DataChangeController@index');
//    $router->put('data/test', 'DataChangeController@test');
//    $router->put('data/form', 'DataChangeController@changeForms');

//    $router->get('test',function (){
//       return view('admin.checks.layout');
//    });

});
