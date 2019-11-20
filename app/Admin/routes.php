<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('products', ProductController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('inventories', InventoryController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('productions', ProductionController::class);

});
