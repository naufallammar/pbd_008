<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

// Mengubah rute halaman utama (/) agar mengarah ke DashboardController
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

use App\Http\Controllers\BarangController;

Route::resource('barang', BarangController::class);

