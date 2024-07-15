<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use App\Admin\Controllers\AuthController;
use App\Admin\Controllers\UserController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\StoreController;
use App\Admin\Controllers\ReviewController;
use App\Admin\Controllers\SaleController;
use App\Admin\Controllers\AdminUserController;

use Encore\Admin\Facades\Admin;

// 認証ルート
Route::group(['prefix' => config('admin.route.prefix'), 'middleware' => config('admin.route.middleware')], function () {
  Route::get('auth/login', [AuthController::class, 'getLogin'])->name('admin.login');
  Route::post('auth/login', [AuthController::class, 'postLogin']);
  Route::get('auth/logout', [AuthController::class, 'getLogout'])->name('admin.logout');
});

Admin::registerAuthRoutes();

// 管理画面のルート
Route::group([
  'prefix'        => config('admin.route.prefix'),
  'namespace'     => config('admin.route.namespace'),
  'middleware'    => config('admin.route.middleware'),
  'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
  $router->get('/', 'HomeController@index')->name('home');
  $router->resource('users', UserController::class);
  $router->resource('categories', CategoryController::class);
  $router->resource('stores', StoreController::class);
  $router->resource('reviews', ReviewController::class);
  $router->resource('sales', SaleController::class)->only('index');
  $router->resource('auth/users', AdminUserController::class);
  $router->post('stores/import', [StoreController::class, 'csvImport']);
});