<?php

use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\CustomerAccountController;
use App\Http\Controllers\Shop\CustomerAuthController;
use App\Http\Controllers\Shop\ShopController;
use Illuminate\Support\Facades\Route;

Route::prefix('tienda')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'home'])->name('home');

    Route::get('/catalogo', [ShopController::class, 'catalog'])->name('catalog');
    Route::get('/categoria/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/producto/{product}', [ShopController::class, 'product'])->name('product');
    Route::get('/buscar', [ShopController::class, 'search'])->name('search');

    Route::get('/carrito', [CartController::class, 'index'])->name('cart');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/carrito/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrito/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/api/carrito', [CartController::class, 'getCartData'])->name('cart.data');
});

Route::prefix('tienda')->name('shop.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login']);
        Route::get('/registro', [CustomerAuthController::class, 'showRegister'])->name('register');
        Route::post('/registro', [CustomerAuthController::class, 'register']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    });
});

Route::prefix('tienda/mi-cuenta')->name('shop.account.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [CustomerAccountController::class, 'index'])->name('index');
    Route::get('/pedidos', [CustomerAccountController::class, 'orders'])->name('orders');
    Route::get('/pedidos/{order}', [CustomerAccountController::class, 'orderDetail'])->name('orders.show');
    Route::get('/perfil', [CustomerAccountController::class, 'profile'])->name('profile');
    Route::put('/perfil', [CustomerAccountController::class, 'updateProfile'])->name('profile.update');
});

Route::prefix('tienda/checkout')->name('shop.checkout.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/envio', [CheckoutController::class, 'saveShipping'])->name('shipping');
    Route::get('/pago', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/procesar', [CheckoutController::class, 'process'])->name('process');
    Route::get('/confirmacion/{order}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});
