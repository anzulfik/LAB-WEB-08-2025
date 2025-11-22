<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

// Halaman utama diarahkan ke produk / stok
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Categories
Route::resource('categories', CategoryController::class);

// Warehouses
Route::resource('warehouses', WarehouseController::class);

// Products
Route::resource('products', ProductController::class);

// Stocks
Route::get('/stocks', [StockController::class, 'index'])
     ->name('stocks.index');

Route::get('/stocks/transfer', [StockController::class, 'transferForm'])
     ->name('stocks.transferForm');

Route::post('/stocks/transfer', [StockController::class, 'transfer'])
     ->name('stocks.transfer');

