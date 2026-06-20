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
    Route::resource('peminjaman', PeminjamanController::class);
});

// Group route bawaan Breeze untuk ganti password/profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Admin & Operator
Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Fitur pengembalian alat
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::resource('user', UserController::class);
});
// Group route KHUSUS ADMIN (Menggunakan custom middleware 'admin')
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('kategori', KategoriAlatController::class);
    Route::resource('alat', AlatRisetController::class);
});

require __DIR__ . '/auth.php';
