<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('shop.home');
});

require __DIR__ . '/shop.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/turbo.php';
