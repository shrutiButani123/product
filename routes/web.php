<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:user'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create/{product}', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store/{product}', [OrderController::class, 'store'])->name('orders.store');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
    });


    // Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    // Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
});