<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Middleware\CekRoleSuperadmin;
use App\Http\Controllers\PenjualanController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthPageController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthPageController::class, 'login'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthPageController::class, 'logout'])->name('logout');

    Route::get('/kasir', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('/kasir', [PenjualanController::class, 'store'])->name('penjualan.store');

    Route::middleware([CekRoleSuperadmin::class])->group(function () {
        Route::get('/laporan-keuntungan', [BarangController::class, 'laporanProfit'])->name('laporan.profit');
        Route::resource('barang', BarangController::class);
    });
});
