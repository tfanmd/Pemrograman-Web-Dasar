<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriAlatController;
use App\Http\Controllers\AlatRisetController;
// use App\Http\Controllers\PeminjamanController;

use Illuminate\Support\Facades\Route;

// Halaman awal saat web dibuka
Route::get('/', function () {
    // Biar cepat, user yang buka halaman utama langsung dilempar ke halaman login
    return redirect('/login');
});

// Group route untuk SEMUA user yang sudah login (Admin & User biasa)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Nanti route untuk User pinjam alat ditaruh di sini
    // Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'create', 'store']);
});

// Group route bawaan Breeze untuk ganti password/profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group route KHUSUS ADMIN (Menggunakan custom middleware 'admin')
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('kategori', KategoriAlatController::class);
    Route::resource('alat', AlatRisetController::class);

    // Route khusus admin untuk validasi peminjaman dan lihat laporan
    // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

require __DIR__ . '/auth.php';
