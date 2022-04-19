<?php

use App\Http\Controllers\ImeiReturnController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductCatalogueController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/samsung/dashboard', function () {
        return view('samsung.dashboard');
    })->name('samsung.dashboard');
});

Route::group(["middleware" => 'auth'], function () {
    // Exports
    Route::get('/orders/export', 'App\Http\Controllers\OrdersController@export');
    Route::get('/returns/export', [ReturnsController::class, 'export']);

    //resources
    Route::resource('orders', OrdersController::class);
    Route::resource('returns', ReturnsController::class)->only('index');
    Route::resource('users', UserController::class)->except('create', 'store');
    Route::resource('samsung/purchase-orders', PurchaseOrderController::class)->only('index','edit');
    Route::resource('samsung/product-catalogues', ProductCatalogueController::class)->only('index', 'create');
    Route::resource('samsung/imei-returns', ImeiReturnController::class)->only('index', 'create');

    Route::group(["middleware" => 'samsungkeepalive'], function () {
        Route::resource('samsung/purchase-orders', PurchaseOrderController::class)->only('update');
        Route::resource('samsung/product-catalogues', ProductCatalogueController::class)->only('store');
        Route::resource('samsung/imei-returns', ImeiReturnController::class)->only('store');

    });
});

