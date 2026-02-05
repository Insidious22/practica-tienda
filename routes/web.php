<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

// Shop Controllers
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CustomerAuthController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\CustomerAccountController;

// ========================================
// REDIRECCIÓN RAÍZ
// ========================================
Route::get('/', function () {
    return redirect()->route('shop.home');
});

// ========================================
// RUTAS PÚBLICAS DE LA TIENDA
// ========================================
Route::prefix('tienda')->name('shop.')->group(function () {
    // Página principal
    Route::get('/', [ShopController::class, 'home'])->name('home');

    // Catálogo y productos
    Route::get('/catalogo', [ShopController::class, 'catalog'])->name('catalog');
    Route::get('/categoria/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/producto/{product}', [ShopController::class, 'product'])->name('product');
    Route::get('/buscar', [ShopController::class, 'search'])->name('search');

    // Carrito (disponible para invitados)
    Route::get('/carrito', [CartController::class, 'index'])->name('cart');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/carrito/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrito/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');

    // API para carrito (AJAX)
    Route::get('/api/carrito', [CartController::class, 'getCartData'])->name('cart.data');
});

// ========================================
// AUTENTICACIÓN DE CLIENTES
// ========================================
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

// ========================================
// ÁREA DE CLIENTE (requiere login)
// ========================================
Route::prefix('tienda/mi-cuenta')->name('shop.account.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [CustomerAccountController::class, 'index'])->name('index');
    Route::get('/pedidos', [CustomerAccountController::class, 'orders'])->name('orders');
    Route::get('/pedidos/{order}', [CustomerAccountController::class, 'orderDetail'])->name('orders.show');
    Route::get('/perfil', [CustomerAccountController::class, 'profile'])->name('profile');
    Route::put('/perfil', [CustomerAccountController::class, 'updateProfile'])->name('profile.update');
});

// ========================================
// CHECKOUT (requiere login como cliente)
// ========================================
Route::prefix('tienda/checkout')->name('shop.checkout.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/envio', [CheckoutController::class, 'saveShipping'])->name('shipping');
    Route::get('/pago', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/procesar', [CheckoutController::class, 'process'])->name('process');
    Route::get('/confirmacion/{order}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});

// ========================================
// RUTAS DE ADMINISTRACIÓN
// ========================================
// TODO: Agregar middleware(['auth', 'admin']) cuando se configure autenticación de admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('productos', ProductController::class);
    Route::resource('zonas', ZoneController::class);
    Route::resource('categorias', CategoryController::class);
});

// ========================================
// LOGIN DE ADMIN (acceso sin middleware admin)
// ========================================
Route::get('/admin/login', [CustomerAuthController::class, 'showLogin'])->name('admin.login');
