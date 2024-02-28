<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Produk\LaporanProdukController;
use App\Http\Controllers\Produk\ProdukController;
use App\Http\Controllers\Ramwater\DatangBarang\DatangBarangControler;
use App\Http\Controllers\Ramwater\DatangBarang\LaporanDatangBarangControler;
use App\Http\Controllers\Ramwater\Kasbon\KasbonController;
use App\Http\Controllers\Ramwater\Kasbon\LaporanKasbonController;
use App\Http\Controllers\Ramwater\Operasional\LaporanOperasionalController;
use App\Http\Controllers\Ramwater\Operasional\OperasionalController;
use App\Http\Controllers\Ramwater\Pembelian\LaporanPembelianController;
use App\Http\Controllers\Ramwater\Pembelian\PembelianController;
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
        // Route::get('/', [RamwaterController::class, 'dashboard'])->name('ramwater.dashboard.dashboard');
        // Route::get('/monitoring/data', [RamwaterController::class, 'monitoring_data'])->name('ramwater.dashboard.monitoring.monitoring_data');
        // Route::get('/monitoring', [RamwaterController::class, 'monitoring'])->name('ramwater.dashboard.monitoring');

        Route::resource('/pembelian', PembelianController::class)->except('show');
        Route::prefix('pembelian')->group(function () {
            Route::get('/data', [PembelianController::class, 'data'])->name('pembelian.data');
            Route::get('/laporan', [LaporanPembelianController::class, 'index'])->name('pembelian.index');
            Route::get('laporan/data', [LaporanPembelianController::class, 'data'])->name('pembelian.laporan.data');
            Route::get('laporan/detailData', [LaporanPembelianController::class, 'detailData'])->name('pembelian.laporan.detailData');
        });

        Route::resource('/produk', ProdukController::class)->except('show');
        Route::prefix('produk')->group(function () {
            Route::get('/data', [produkController::class, 'data'])->name('produk.data');
            Route::get('/laporan', [LaporanProdukController::class, 'laporan'])->name('produk.laporan');
            Route::get(
                'laporan/data',
                [LaporanprodukController::class, 'data']
            )->name('produk.laporan.data');
        });
    });
});
