<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // Tambahkan ini di bagian atas

Route::get('/', function () {
    return view('welcome');
});

// Ini akan membuat 7 rute CRUD secara otomatis:
// GET /products          -> ProductController@index
// GET /products/create   -> ProductController@create
// POST /products         -> ProductController@store
// GET /products/{product} -> ProductController@show
// ...dst
Route::resource('products', ProductController::class);