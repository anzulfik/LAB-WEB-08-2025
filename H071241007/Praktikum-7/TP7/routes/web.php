<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/destinasi', [HomeController::class, 'destinasi'])->name('destinasi');
Route::get('/kuliner', [HomeController::class, 'kuliner']);
Route::get('/galeri', [HomeController::class, 'galeri']);
Route::get('/kontak', [HomeController::class, 'kontak']);