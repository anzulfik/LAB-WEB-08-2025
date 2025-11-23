<?php

use App\Http\Controllers\FishController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FishController::class, 'tampilkanSemua'])->name('home');

Route::prefix('ikan')->name('ikan.')->group(function () {
    Route::get('/', [FishController::class, 'tampilkanSemua'])->name('index');
    Route::get('/buat', [FishController::class, 'buat'])->name('create');
    Route::post('/', [FishController::class, 'simpan'])->name('store');
    Route::get('/{fish}', [FishController::class, 'tampilkan'])->name('show');
    Route::get('/{fish}/ubah', [FishController::class, 'ubah'])->name('edit');
    Route::put('/{fish}', [FishController::class, 'perbarui'])->name('update');
    Route::delete('/{fish}', [FishController::class, 'hapus'])->name('destroy');
});