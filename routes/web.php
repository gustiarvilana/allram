<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\pelanggan\LaporanPelangganController;
use App\Http\Controllers\pelanggan\PelangganController;
use App\Http\Controllers\Produk\LaporanProdukController;
use App\Http\Controllers\Produk\ProdukController;
use App\Http\Controllers\Ramwater\Hutang\HutangGalonController;
use App\Http\Controllers\Ramwater\Hutang\HutangNominalController;
use App\Http\Controllers\Ramwater\Ops\OpsController;
use App\Http\Controllers\Ramwater\Pembelian\DetailPembelianController;
use App\Http\Controllers\Ramwater\Pembelian\PembayaranController as PembelianPembayaranController;
use App\Http\Controllers\Ramwater\Pembelian\PembelianController;
use App\Http\Controllers\Ramwater\Penjualan\DetailPenjualanController;
use App\Http\Controllers\Ramwater\Penjualan\PembayaranController as PenjualanPembayaranController;
use App\Http\Controllers\Ramwater\Penjualan\PenjualanController;
use App\Http\Controllers\Security\KaryawanController;
use App\Http\Controllers\Security\SecurityController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Security\UserMenuController;
use App\Http\Controllers\Security\UserRoleController;
use App\Http\Controllers\Security\UserRoleMenuController;
use App\Http\Controllers\Utility\UtilityController;

use App\Http\Controllers\Ramwater\Ops\LaporanOpsController;
use App\Http\Controllers\Ramwater\Pembelian\LaporanPembelianController;
use App\Http\Controllers\Ramwater\Penjualan\LaporanPenjualanController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/add', [UtilityController::class, 'add']);

Route::post('/utility/setsession', [UtilityController::class, 'setSession'])->name('utility.setSession');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

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

        Route::resource('/produk', ProdukController::class)->except('show');
        Route::prefix('produk')->group(function () {
            Route::get('/data', [ProdukController::class, 'data'])->name('produk.data');
            Route::get('/laporan', [LaporanProdukController::class, 'laporan'])->name('produk.laporan');
            Route::get('laporan/data', [LaporanProdukController::class, 'data'])->name('produk.laporan.data');
        });

        Route::resource('/pelanggan', PelangganController::class)->except('show');
        Route::prefix('pelanggan')->group(function () {
            Route::get('/data', [PelangganController::class, 'data'])->name('pelanggan.data');
            Route::get('/laporan', [LaporanPelangganController::class, 'laporan'])->name('pelanggan.laporan');
            Route::get('laporan/data', [LaporanPelangganController::class, 'data'])->name('pelanggan.laporan.data');
        });

        Route::resource('/pembelian', PembelianController::class)->except('show');
        Route::prefix('pembelian')->group(function () {
            Route::get('/data', [PembelianController::class, 'data'])->name('pembelian.data');
            Route::get('/detail', [DetailPembelianController::class, 'index'])->name('pembelian.index');
            Route::get('detail/data', [DetailPembelianController::class, 'data'])->name('pembelian.detail.data');
            Route::get('detail/detailData', [DetailPembelianController::class, 'detailData'])->name('pembelian.detail.detailData');

            Route::resource('/pembayaran', PembelianPembayaranController::class)->except('show');
            Route::prefix('pembayaran')->group(function () {
                Route::get('/data', [PembelianPembayaranController::class, 'data'])->name('pembayaran.data');
                Route::post('/store', [PembelianPembayaranController::class, 'store'])->name('pembelian.pembayaran.store');
                Route::delete('/destroy/{id}', [PembelianPembayaranController::class, 'destroy'])->name('pembelian.pembayaran.destroy');
            });
        });

        Route::resource('/penjualan', PenjualanController::class)->except('show');
        Route::prefix('penjualan')->group(function () {
            Route::get('/data', [penjualanController::class, 'data'])->name('penjualan.data');
            Route::get('/penyerahan', [penjualanController::class, 'penyerahan'])->name('penjualan.penyerahan');
            Route::post('/penyerahan', [penjualanController::class, 'penyerahanUpdate'])->name('penjualan.penyerahanUpdate');
            Route::get('/detail', [DetailPenjualanController::class, 'index'])->name('penjualan.detail.index');
            Route::get('detail/data', [DetailPenjualanController::class, 'data'])->name('penjualan.detail.data');
            Route::get('detail/detailData', [DetailPenjualanController::class, 'detailData'])->name('penjualan.detail.detailData');

            Route::resource('/pembayaran', PenjualanPembayaranController::class)->except('show');
            Route::prefix('pembayaran')->group(function () {
                Route::get('/data', [PenjualanPembayaranController::class, 'data'])->name('penjualan.pembayaran.data');
                Route::post('/store', [PenjualanPembayaranController::class, 'store'])->name('penjualan.pembayaran.store');
                Route::delete('/destroy/{id}', [PenjualanPembayaranController::class, 'destroy'])->name('penjualan.pembayaran.destroy');
            });
        });

        Route::resource('/ops', OpsController::class)->except('show');
        Route::prefix('ops')->group(function () {
            Route::get('/data', [OpsController::class, 'data'])->name('ops.data');
        });

        Route::prefix('laporan')->group(function () {
            Route::get('/pembelian', [LaporanPembelianController::class, 'index'])->name('pembelian.laporan');
            Route::get('/pembelian/data', [LaporanPembelianController::class, 'data'])->name('pembelian.laporan.data');

            Route::get('/penjualan', [LaporanPenjualanController::class, 'index'])->name('penjualan.laporan');
            Route::get('/penjualan/data', [LaporanPenjualanController::class, 'data'])->name('penjualan.laporan.data');

            Route::get('/ops', [LaporanOpsController::class, 'index'])->name('ops.laporan');
            Route::get('/ops/data', [LaporanOpsController::class, 'data'])->name('ops.laporan.data');
        });

        Route::prefix('hutang')->group(function () {
            Route::get('/nominal', [HutangNominalController::class, 'index'])->name('hutang.nominal');

            Route::get('/galon', [HutangGalonController::class, 'index'])->name('hutang.galon');
        });
    });
});
