<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpiredProductController; // TAMBAH INI

Route::get('/', function () {
    return view('welcome');
});

// Rute CRUD produk
Route::resource('products', ProductController::class);

// TAMBAHAN: Rute untuk monitoring expired products
Route::prefix('products')->group(function () {
    Route::get('/nearly-expired', [ProductController::class, 'nearlyExpired'])->name('products.nearly-expired');
    Route::get('/expired', [ProductController::class, 'expired'])->name('products.expired');
});