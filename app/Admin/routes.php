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
    $router->resource('groups', 'TblOrderZGroupController');
    $router->resource('notices', 'TblNoticeController');
    $router->resource('checks', 'TblOrderCheckController');

});
