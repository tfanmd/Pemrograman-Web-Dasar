<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriAlatController;
use App\Http\Controllers\AlatRisetController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

// Halaman awal saat web dibuka
Route::get('/', function () {
    return redirect('/login');
});

// Group route untuk SEMUA user yang sudah login (Admin & User biasa)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cukup 1 Route ini saja untuk Peminjaman, biarkan terbuka penuh. 
    // (Proteksi lihat detail data orang lain sudah aman di dalam Controller)
    Route::resource('peminjaman', PeminjamanController::class);
});

// Group route bawaan Breeze untuk ganti password/profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group route KHUSUS ADMIN (Menggunakan custom middleware 'admin')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriAlatController::class);
    Route::resource('alat', AlatRisetController::class);

    // Route::resource('peminjaman', PeminjamanController::class); <-- INI DIHAPUS

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

require __DIR__ . '/auth.php';
