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

    $router->get('/', 'HomeController@index');
    $router->resource('users', 'TblUserController');
    $router->resource('menus', 'TblOrderZMenuController');
//    $router->post('menus/confirm1', 'TblOrderZMenuController@confirm1');
    $router->resource('groups', 'TblOrderZGroupController');
    $router->resource('notices', 'TblNoticeController');
    $router->resource('checks', 'TblOrderCheckController');
    $router->resource('shopgroups', 'ShopGroupController');
    $router->resource('reports', 'ReportController');


    //export
    $router->resource('export/salesbyshopandmenu', 'Export\SalesByShopAndMenuController');

    //api
    $router->get('api/group', 'ApiController@group');
    $router->get('api/group2', 'ApiController@group2');
    $router->get('api/cat', 'ApiController@cat');
    $router->get('api/unit', 'ApiController@unit');
    $router->get('api/shopgroup', 'ApiController@shop_group');
    $router->get('api/export', 'ApiController@export');

});
