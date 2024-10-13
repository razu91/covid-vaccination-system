<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'register');

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register','index')->name('register');
    Route::post('/register', 'store')->name('register.store');
});

Route::controller(SearchController::class)->group(function () {
    Route::get('search/vaccination-status','searchVaccinationStatus')->name('search.vaccination-status');
});
