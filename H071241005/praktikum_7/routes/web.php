<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Rute untuk Halaman Home
Route::get('/', [HomeController::class, 'home']);
Route::get('/destinasi', [HomeController::class, 'destinasi']);
Route::get('/galeri', [HomeController::class, 'galeri']);
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::get('/kuliner', [HomeController::class, 'kuliner']);

// Rute untuk Halaman Destinasi
// Route::get('/destinasi', function () {
//     return view('destinasi');
// });

// // Rute untuk Halaman Kuliner
// Route::get('/kuliner', function () {
//     return view('kuliner');
// });

// // Rute untuk Halaman Galeri
// Route::get('/galeri', function () {
//     return view('galeri');
// });

// // Rute untuk Halaman Kontak
// Route::get('/kontak', function () {
//     return view('kontak');
// });