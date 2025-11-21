<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;

// Dashboard
Route::get('/search', [DashboardController::class, 'search'])->name('dashboard.search');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Resource routes
Route::resource('categories', CategoryController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('products', ProductController::class);

// Halaman stok
Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');

// Form transfer stok
Route::get('stocks/transfer', [StockController::class, 'showTransferForm'])
    ->name('stocks.transfer');

// Proses transfer stok (POST)
Route::post('stocks/transfer', [StockController::class, 'transfer'])
    ->name('stocks.transfer.process');

// Ajax cek stok
Route::post('stocks/check', [StockController::class, 'checkStock'])
    ->name('stocks.check');
