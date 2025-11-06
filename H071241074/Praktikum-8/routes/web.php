<?php

use App\Http\Controllers\FishController;

Route::get('/', fn() => redirect()->route('fishes.index'));
Route::resource('fishes', FishController::class);

