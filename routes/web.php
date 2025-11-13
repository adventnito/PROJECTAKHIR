<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // CRUD Barang
    Route::get('/barang', [AdminController::class, 'barangIndex'])->name('admin.barang.index');
    Route::get('/barang/create', [AdminController::class, 'barangCreate'])->name('admin.barang.create');
    Route::post('/barang', [AdminController::class, 'barangStore'])->name('admin.barang.store');
    Route::get('/barang/{barang}/edit', [AdminController::class, 'barangEdit'])->name('admin.barang.edit');
    Route::put('/barang/{barang}', [AdminController::class, 'barangUpdate'])->name('admin.barang.update');
    Route::delete('/barang/{barang}', [AdminController::class, 'barangDestroy'])->name('admin.barang.destroy');
    
    // Manajemen Mahasiswa
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index');
    Route::get('/mahasiswa/{user}/peminjaman', [AdminController::class, 'mahasiswaPeminjaman'])->name('admin.mahasiswa.peminjaman');
    
    // Manajemen Peminjaman
    Route::get('/peminjaman', [AdminController::class, 'peminjamanIndex'])->name('admin.peminjaman.index');
    Route::post('/peminjaman/{peminjaman}/approve', [AdminController::class, 'approvePeminjaman'])->name('admin.peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [AdminController::class, 'rejectPeminjaman'])->name('admin.peminjaman.reject');
});

// Mahasiswa Routes
Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');