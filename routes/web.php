<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ProductController;
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


Auth::routes(['login', 'register']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/product/preview/{product}', [ProductController::class, 'show'])->name('product.show');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/checkout', [CheckOutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckOutController::class, 'index']);

    Route::post('/checkout/proccess', [CheckOutController::class, 'checkout'])->name('checkout.process');

    Route::get('/checkout/complete', [CheckOutController::class, 'complete'])->name('checkout.complete');

    Route::get('/product/data', [ProductController::class, 'data']);

    Route::resource('product', ProductController::class)->except('show');

    Route::resource('cart', CartController::class)->only(['index', 'store', 'update', 'destroy']);
});
