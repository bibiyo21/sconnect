<?php

use App\Http\Controllers\OrdersController;
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
    Route::resource('samsung/purchase-orders', PurchaseOrderController::class)->except('destroy');
});

