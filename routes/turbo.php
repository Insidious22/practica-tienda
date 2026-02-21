<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('content')->name('content.')->group(function () {
    Route::get('catalog', [ShopProductController::class, 'getCatalog'])->name('catalog');
    Route::get('product/{product}', [ShopProductController::class, 'show'])->name('product');
    Route::get('cart', [ShopProductController::class, 'getCart'])->name('cart');
    Route::post('cart/add', [ShopProductController::class, 'addToCart'])->name('cart.add');
});

Route::middleware(['auth', 'admin.or.superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('products/list', [AdminProductController::class, 'getList'])->name('products.list');
        Route::get('products/form', [AdminProductController::class, 'getForm'])->name('products.form');
        Route::get('products/{product}/form', [AdminProductController::class, 'getForm'])->name('products.form.edit');
        Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
        Route::patch('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    });
