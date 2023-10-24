<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Ramwater\DatangBarangControler;
use App\Http\Controllers\Ramwater\DGalonController;
use App\Http\Controllers\Ramwater\PenjualanController;
use App\Http\Controllers\Ramwater\RamwaterController;
use App\Http\Controllers\Security\KaryawanController;
use App\Http\Controllers\Security\MenuByRoleController;
use App\Http\Controllers\Security\SecurityController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Security\UserMenuController;
use App\Http\Controllers\Security\UserRoleController;
use App\Http\Controllers\Security\UserRoleMenuController;
use App\Http\Controllers\Utility\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/utility/setsession', [UtilityController::class, 'setSession'])->name('utility.setSession');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['roles:99,1'])->group(function () {
    Route::get('/security', [SecurityController::class, 'index'])->name('security.home');

    Route::prefix('security')->group(function () {
        Route::get('/user_menu/data', [UserMenuController::class, 'data'])->name('user_menu.data');
        Route::resource('/user_menu', UserMenuController::class)->except('show');

        Route::get('/karyawan/data', [KaryawanController::class, 'data'])->name('karyawan.data');
        Route::resource('/karyawan', KaryawanController::class)->except('show');

        Route::resource('/user', UserController::class)->except('show');

        Route::get('/user_role/data', [UserRoleController::class, 'data'])->name('user_role.data');
        Route::resource('/user_role', UserRoleController::class)->except('show');

        Route::get('/user_role/user_role_menu/getMenu', [UserRoleMenuController::class, 'getMenuByRole'])->name('user_role_menu.getMenuByRole');
        Route::resource('/user_role_menu', UserRoleMenuController::class)->except('show');
    });
});

Route::middleware(['roles:99,1,2'])->group(function () {
    Route::get('/ramwater', [RamwaterController::class, 'index'])->name('ramwater.home');
    Route::prefix('ramwater')->group(function () {
        Route::get('/datangbarang/data', [DatangBarangControler::class, 'data'])->name('datangbarang.data');
        Route::resource('/datangbarang', DatangBarangControler::class)->except('show');

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::resource('/penjualan', PenjualanController::class)->except('show');

        Route::get('/galon/data/{id}', [DGalonController::class, 'data'])->name('galon.data');
        Route::resource('/galon', DGalonController::class)->except('show');
    });
});
