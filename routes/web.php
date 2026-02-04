<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('productos.index');
});

Route::resource('productos', ProductController::class);
Route::resource('zonas', ZoneController::class);
Route::resource('categorias', CategoryController::class);
