<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Security\SecurityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['roles:99,1'])->group(function () {
    Route::get('/security', [SecurityController::class, 'index'])->name('home');
});
