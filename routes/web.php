<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Security\SecurityController;
use App\Http\Controllers\Security\UserMenuController;
use App\Http\Controllers\Utility\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/utility/setsession', [UtilityController::class, 'setSession'])->name('utility.setSession');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['roles:99,1'])->group(function () {
    Route::get('/security', [SecurityController::class, 'index'])->name('home');

    Route::get('/security/user_menu', [UserMenuController::class, 'index'])->name('security.usermenu.index');
    Route::get('/security/user_menu/data', [UserMenuController::class, 'data'])->name('security.usermenu.data');
    Route::POST('/security/user_menu/store', [UserMenuController::class, 'store'])->name('security.usermenu.store');
    Route::delete('/security/user_menu/destroy/{id}', [UserMenuController::class, 'destroy'])->name('security.usermenu.destroy');
    Route::put('/security/user_menu/update/{id}', [UserMenuController::class, 'update'])->name('security.usermenu.update');
});
