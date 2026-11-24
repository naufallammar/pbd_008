<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MasterDataController;
use App\Http\Middleware\CekRoleSuperadmin;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthPageController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthPageController::class, 'login'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthPageController::class, 'logout'])->name('logout');

    // Modul Kasir / Penjualan (Superadmin & Kasir)
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');

    // Modul Pengadaan & Penerimaan (Superadmin & Gudang)
    Route::get('/pengadaan', [PengadaanController::class, 'index'])->name('pengadaan.index');
    Route::get('/pengadaan/create', [PengadaanController::class, 'create'])->name('pengadaan.create');
    Route::post('/pengadaan', [PengadaanController::class, 'store'])->name('pengadaan.store');
    Route::get('/pengadaan/{id}', [PengadaanController::class, 'show'])->name('pengadaan.show');

    Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
    Route::get('/penerimaan/create', [PenerimaanController::class, 'create'])->name('penerimaan.create');
    Route::post('/penerimaan', [PenerimaanController::class, 'store'])->name('penerimaan.store');
    Route::get('/penerimaan/{id}', [PenerimaanController::class, 'show'])->name('penerimaan.show');

    // Khusus Superadmin (Semua Master Data)
    Route::middleware([CekRoleSuperadmin::class])->group(function () {
        // Master Barang
        Route::resource('barang', BarangController::class);

        // Master Role
        Route::get('/master/role', [MasterDataController::class, 'indexRole'])->name('master.role');
        Route::post('/master/role', [MasterDataController::class, 'storeRole'])->name('master.role.store');
        Route::put('/master/role/{id}', [MasterDataController::class, 'updateRole'])->name('master.role.update');
        Route::delete('/master/role/{id}', [MasterDataController::class, 'destroyRole'])->name('master.role.destroy');

        // Master User
        Route::get('/master/user', [MasterDataController::class, 'indexUser'])->name('master.user');
        Route::post('/master/user', [MasterDataController::class, 'storeUser'])->name('master.user.store');
        Route::put('/master/user/{id}', [MasterDataController::class, 'updateUser'])->name('master.user.update');
        Route::delete('/master/user/{id}', [MasterDataController::class, 'destroyUser'])->name('master.user.destroy');

        // Master Satuan
        Route::get('/master/satuan', [MasterDataController::class, 'indexSatuan'])->name('master.satuan');
        Route::post('/master/satuan', [MasterDataController::class, 'storeSatuan'])->name('master.satuan.store');
        Route::put('/master/satuan/{id}', [MasterDataController::class, 'updateSatuan'])->name('master.satuan.update');
        Route::delete('/master/satuan/{id}', [MasterDataController::class, 'destroySatuan'])->name('master.satuan.destroy');

        // Master Vendor
        Route::get('/master/vendor', [MasterDataController::class, 'indexVendor'])->name('master.vendor');
        Route::post('/master/vendor', [MasterDataController::class, 'storeVendor'])->name('master.vendor.store');
        Route::put('/master/vendor/{id}', [MasterDataController::class, 'updateVendor'])->name('master.vendor.update');
        Route::delete('/master/vendor/{id}', [MasterDataController::class, 'destroyVendor'])->name('master.vendor.destroy');

        // Master Margin Penjualan
        Route::get('/master/margin', [MasterDataController::class, 'indexMargin'])->name('master.margin');
        Route::post('/master/margin', [MasterDataController::class, 'storeMargin'])->name('master.margin.store');
        Route::put('/master/margin/{id}/aktifkan', [MasterDataController::class, 'aktifkanMargin'])->name('margin.aktifkan');
        Route::put('/master/margin/{id}/nonaktifkan', [MasterDataController::class, 'nonaktifkanMargin'])->name('margin.nonaktifkan');
    });
});
