<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;


Route::get('/', [CategoryController::class, 'index'])->name('home');

// Routes untuk Categories
Route::resource('categories', CategoryController::class);

// Routes untuk Warehouses
Route::resource('warehouses', WarehouseController::class);

// Routes untuk Products
Route::resource('products', ProductController::class);

// Routes untuk Stock Management
Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::post('stock/transfer', [StockController::class, 'transfer'])->name('stock.transfer');