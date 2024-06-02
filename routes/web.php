<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/product', [App\Http\Controllers\Products\ProductsController::class, 'index'])->name('product');
Route::get('/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart');
Route::get('/product/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('addcart');
Route::patch('/update-cart', [App\Http\Controllers\Products\ProductsController::class, 'updateCart'])->name('updatecart');
Route::patch('/delete-cart', [App\Http\Controllers\Products\ProductsController::class, 'deleteCart'])->name('deletecart');

// Route::get('/product', [ProductsController::class, 'index'])->name('product');