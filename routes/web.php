<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Ramwater\DatangBarang\DatangBarangControler;
use App\Http\Controllers\Ramwater\DatangBarang\LaporanDatangBarangControler;
use App\Http\Controllers\Ramwater\Kasbon\KasbonController;
use App\Http\Controllers\Ramwater\Kasbon\LaporanKasbonController;
use App\Http\Controllers\Ramwater\Operasional\LaporanOperasionalController;
use App\Http\Controllers\Ramwater\Operasional\OperasionalController;
use App\Http\Controllers\Ramwater\Penjualan\DGalonController;
use App\Http\Controllers\Ramwater\Penjualan\DHutangController;
use App\Http\Controllers\Ramwater\Penjualan\LaporanPenjualanControler;
use App\Http\Controllers\Ramwater\Penjualan\PenjualanController;
use App\Http\Controllers\Ramwater\Penjualan\PenjualandetailController;
use App\Http\Controllers\Ramwater\Pinjaman\LaporanPinjamanController;
use App\Http\Controllers\Ramwater\Pinjaman\PinjamanController;
use App\Http\Controllers\Ramwater\Report\RamwaterController;
use App\Http\Controllers\Security\KaryawanController;
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

Route::middleware(['auth', 'roles:99,1'])->group(function () {
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

Route::middleware(['auth', 'roles:99,1,2'])->group(function () {
    Route::prefix('ramwater')->group(function () {
        Route::get('/', [RamwaterController::class, 'dashboard'])->name('ramwater.dashboard.dashboard');
        Route::get('/monitoring/data', [RamwaterController::class, 'monitoring_data'])->name('ramwater.dashboard.monitoring.monitoring_data');
        Route::get('/monitoring', [RamwaterController::class, 'monitoring'])->name('ramwater.dashboard.monitoring');

        Route::get('/datangbarang/data', [DatangBarangControler::class, 'data'])->name('datangbarang.data');
        Route::resource('/datangbarang', DatangBarangControler::class)->except('show');
        Route::get('/datangbarang/laporan', [LaporanDatangBarangControler::class, 'laporan'])->name('datangbarang.laporan');
        Route::get('/datangbarang/laporan/data', [LaporanDatangBarangControler::class, 'data'])->name('datangbarang.laporan.data');

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::resource('/penjualan', PenjualanController::class)->except('show');
        Route::get('/penjualan/laporan', [LaporanPenjualanControler::class, 'laporan'])->name('penjualan.laporan');
        Route::get('/penjualan/laporan/data', [LaporanPenjualanControler::class, 'data'])->name('penjualan.laporan.data');
        Route::get('/penjualan/laporan/perProduk', [LaporanPenjualanControler::class, 'perProduk'])->name('penjualan.laporan.perProduk');

        Route::get('/penjualan/galon/data', [DGalonController::class, 'data'])->name('galon.data');
        Route::resource('/penjualan/galon', DGalonController::class)->except('show');

        Route::get('/penjualan/hutang/data', [DHutangController::class, 'data'])->name('hutang.data');
        Route::resource('/penjualan/hutang', DHutangController::class)->except('show');

        Route::get('/penjualandetail/data/{id}', [PenjualandetailController::class, 'data'])->name('penjualandetail.data');
        Route::resource('/penjualandetail', PenjualandetailController::class)->except('show');

        Route::resource('/operasional', OperasionalController::class)->except('show');
        Route::prefix('operasional')->group(function () {
            Route::get('/data', [OperasionalController::class, 'data'])->name('operasional.data');
            Route::get('/laporan', [LaporanOperasionalController::class, 'laporan'])->name('operasional.laporan');
            Route::get('laporan/data', [LaporanOperasionalController::class, 'data'])->name('operasional.laporan.data');
        });

        Route::resource('/kasbon', KasbonController::class)->except('show');
        Route::prefix('kasbon')->group(function () {
            Route::get('/data', [KasbonController::class, 'data'])->name('kasbon.data');
            Route::get('/laporan', [LaporanKasbonController::class, 'laporan'])->name('kasbon.laporan');
            Route::get('laporan/data', [LaporanKasbonController::class, 'data'])->name('kasbon.laporan.data');
        });

        Route::resource('/pinjaman', PinjamanController::class)->except('show');
        Route::prefix('pinjaman')->group(function () {
            Route::get('/data', [PinjamanController::class, 'data'])->name('pinjaman.data');
            Route::get('/laporan', [LaporanPinjamanController::class, 'laporan'])->name('pinjaman.laporan');
            Route::get('laporan/data', [LaporanPinjamanController::class, 'data'])->name('pinjaman.laporan.data');
        });
    });
});
