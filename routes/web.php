<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // CRUD Barang
        Route::get('/barang', [AdminController::class, 'barangIndex'])->name('admin.barang.index');
        Route::get('/barang/create', [AdminController::class, 'barangCreate'])->name('admin.barang.create');
        Route::post('/barang', [AdminController::class, 'barangStore'])->name('admin.barang.store');
        Route::get('/barang/{barang}/edit', [AdminController::class, 'barangEdit'])->name('admin.barang.edit');
        Route::put('/barang/{barang}', [AdminController::class, 'barangUpdate'])->name('admin.barang.update');
        Route::delete('/barang/{barang}', [AdminController::class, 'barangDestroy'])->name('admin.barang.destroy');
        
        // Manajemen Mahasiswa - TAMBAHKAN INI
        Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index');
        Route::get('/mahasiswa/{user}/peminjaman', [AdminController::class, 'mahasiswaPeminjaman'])->name('admin.mahasiswa.peminjaman');
        
        // Manajemen Peminjaman
        Route::get('/peminjaman', [AdminController::class, 'peminjamanIndex'])->name('admin.peminjaman.index');
        Route::post('/peminjaman/{peminjaman}/approve', [AdminController::class, 'approvePeminjaman'])->name('admin.peminjaman.approve');
        Route::post('/peminjaman/{peminjaman}/reject', [AdminController::class, 'rejectPeminjaman'])->name('admin.peminjaman.reject');
        Route::post('/peminjaman/{peminjaman}/complete', [AdminController::class, 'completePeminjaman'])->name('admin.peminjaman.complete');
    });
    
    // Mahasiswa Routes
    Route::middleware(['mahasiswa'])->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
        Route::get('/profile', [MahasiswaController::class, 'profile'])->name('mahasiswa.profile');
        Route::get('/barang/{id}', [MahasiswaController::class, 'showBarang'])->name('mahasiswa.barang.show');
        Route::get('/search', [MahasiswaController::class, 'searchBarang'])->name('mahasiswa.search');
        Route::post('/cart/add/{id}', [MahasiswaController::class, 'addToCart'])->name('mahasiswa.cart.add');
        Route::put('/cart/update/{id}', [MahasiswaController::class, 'updateCart'])->name('mahasiswa.cart.update');
        Route::delete('/cart/remove/{id}', [MahasiswaController::class, 'removeFromCart'])->name('mahasiswa.cart.remove');
        Route::delete('/cart/clear', [MahasiswaController::class, 'clearCart'])->name('mahasiswa.cart.clear');
        Route::get('/pengajuan', [MahasiswaController::class, 'showPengajuanForm'])->name('mahasiswa.pengajuan.form');
        Route::post('/peminjaman/submit', [MahasiswaController::class, 'submitPeminjaman'])->name('mahasiswa.peminjaman.submit');
        Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('mahasiswa.riwayat');
    });
});