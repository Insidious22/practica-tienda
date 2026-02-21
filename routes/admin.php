<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DataExportController;
use App\Http\Controllers\Admin\DiccionarioController as AdminDiccionarioController;
use App\Http\Controllers\Admin\GuardiaController as AdminGuardiaController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.or.superadmin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/exportar', [DataExportController::class, 'export'])->name('export.data');

    Route::resource('productos', ProductController::class);
    Route::resource('zonas', ZoneController::class);
    Route::resource('categorias', CategoryController::class);
    Route::resource('proveedores', SupplierController::class)->parameters(['proveedores' => 'supplier']);
    Route::resource('diccionario', AdminDiccionarioController::class)->names('diccionario')->except(['show']);

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::resource('usuarios', UserController::class)->names('users')->parameters(['usuarios' => 'user']);

    Route::patch('guardias/{id}/reactivar', [AdminGuardiaController::class, 'reactivar'])->name('guardias.reactivar');
    Route::post('guardias/{guardia}/items', [AdminGuardiaController::class, 'addItem'])->name('guardias.addItem');
    Route::delete('guardia-items/{id}', [AdminItemController::class, 'destroy'])->name('guardias.items.destroy');
    Route::resource('guardias', AdminGuardiaController::class)->names('guardias');
});
