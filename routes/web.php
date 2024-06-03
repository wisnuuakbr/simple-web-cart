<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/product', [App\Http\Controllers\Products\ProductsController::class, 'index'])->name('product');
Route::get('/cart', [App\Http\Controllers\Products\ProductsController::class, 'cart'])->name('cart');
Route::get('/checkout', [App\Http\Controllers\Products\ProductsController::class, 'checkout'])->name('checkout');
Route::get('/product/{id}', [App\Http\Controllers\Products\ProductsController::class, 'addCart'])->name('addcart');
Route::delete('/delete-cart', [App\Http\Controllers\Products\ProductsController::class, 'deleteCart'])->name('deletecart');