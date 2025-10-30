<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;

// Route::get('/home', function () {
//     return view('home');
// });

// Route::get('/destinasi', function () {
//     return view('destinasi');
// });

// Route::get('/kuliner', function () {
//     return view('kuliner');
// });

// Route::get('/peta', function () {
//     return view('peta');
// });

// Route::get('/galeri', function () {
//     return view('galeri');
// });

// Route::get('/kontak', function () {
//     return view('kontak');
// });

Route::get('/home', [pageController::class, 'index'])->name('home');
Route::get('/destinasi', [pageController::class, 'destinasi']);
Route::get('/kuliner', [pageController::class, 'kuliner']);
Route::get('/peta', [pageController::class, 'peta']);
Route::get('/galeri', [pageController::class, 'galeri']);
Route::get('/kontak', [pageController::class, 'kontak']);
