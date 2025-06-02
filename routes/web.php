<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NasabahController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\KreditController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Nasabah\DashboardNasabahController;
use App\Http\Controllers\Owner\DashboardOwnerController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.index');
        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif (auth()->user()->role === 'nasabah') {
            return redirect()->route('nasabah.dashboard');
        }
    }
    return redirect()->route('login');
});

// Redirect authenticated users from login page to their dashboard
Route::get('/login', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.index');
        } elseif (auth()->user()->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif (auth()->user()->role === 'nasabah') {
            return redirect()->route('nasabah.dashboard');
        }
    }
    return view('auth.login');
})->name('login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'role:admin'])->group(function () {
    //resource routes Admin/NasabahController named 'nasabah'
    Route::resource('admin', NasabahController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('kredit', KreditController::class);
    Route::resource('kredit.pembayaran', PembayaranController::class);
    Route::post('kredit/{kredit}/pembayaran/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('kredit.pembayaran.verifikasi');
    Route::post('kredit/{kredit}/pembayaran/{pembayaran}/tolak', [PembayaranController::class, 'tolak'])->name('kredit.pembayaran.tolak');

});

Route::middleware(['auth', 'role:admin,owner'])->group(function() {
    Route::get('/laporan/kredit', [LaporanController::class, 'kredit'])->name('laporan.kredit');
    Route::get('/laporan/pembayaran', [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');
    Route::get('/laporan/nasabah', [LaporanController::class, 'nasabah'])->name('laporan.nasabah');
    Route::get('/laporan/keterlambatan', [LaporanController::class, 'keterlambatan'])->name('laporan.keterlambatan');

});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [DashboardOwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/laporan/kredit', [DashboardOwnerController::class, 'laporanKredit'])->name('laporan.kredit');
    Route::get('/owner/laporan/pembayaran', [DashboardOwnerController::class, 'laporanPembayaran'])->name('laporan.pembayaran');
    Route::get('/owner/laporan/nasabah', [DashboardOwnerController::class, 'laporanNasabah'])->name('laporan.nasabah');
    Route::get('/owner/laporan/keterlambatan', [DashboardOwnerController::class, 'laporanKeterlambatan'])->name('laporan.keterlambatan');
});

Route::middleware(['auth', 'role:nasabah'])->group(function() {
    Route::get('/nasabah/dashboard', [DashboardNasabahController::class, 'index'])->name('nasabah.dashboard');
    Route::get('/nasabah/pembayaran/{kredit}', [PembayaranController::class, 'create'])->name('nasabah.pembayaran.create');
    Route::post('/nasabah/pembayaran/{kredit}', [PembayaranController::class, 'store'])->name('nasabah.pembayaran.store');
    Route::get('/nasabah/riwayat-pembayaran/{kredit}', [DashboardNasabahController::class, 'riwayatPembayaran'])->name('nasabah.riwayat');
    Route::post('/nasabah/pembayaran/{kredit}/{pembayaran}/upload-bukti', [DashboardNasabahController::class, 'uploadBuktiPembayaran'])->name('nasabah.pembayaran.upload-bukti');
});



require __DIR__.'/auth.php';
