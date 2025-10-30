<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi', [HomeController::class, 'destinasi'])->name('destinasi');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kuliner', [HomeController::class, 'kuliner'])->name('kuliner');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/event', [HomeController::class, 'event'])->name('event');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');