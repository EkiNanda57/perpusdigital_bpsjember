<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PublikasiController;


// -- HALAMAN UTAMA --
Route::get('/', function () {
    return view('landingpage');
});

// DASHBOARD OPERATOR
Route::get('/operator/dashboard', [PublikasiController::class, 'dashboardOperator'])
    ->name('operator.dashboard');

    
// Arahkan URL /users ke method 'index' di dalam PenggunaController
Route::get('/publikasi-saya', [PublikasiController::class, 'index'])->name('publikasi.index');

// -- LOGIN & REGISTER --

// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -- DASHBOARD (DENGAN CONTROLLER MASING-MASING) --
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard-user.admin-dashboard');
    Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('dashboard-user.operator-dashboard');
    Route::get('/pengguna/dashboard', [PenggunaController::class, 'index'])->name('dashboard-user.pengguna-dashboard');

    // CRUD kategori (hanya untuk admin biasanya)
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.kategori');
    Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.addkategori');
    Route::post('/kategori/simpan', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.editkategori');
    Route::put('/kategori/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/hapus/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // CRUD Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.publikasi');
    Route::get('/publikasi/tambah', [PublikasiController::class, 'create'])->name('publikasi.create');
    Route::post('/publikasi/simpan', [PublikasiController::class, 'store'])->name('publikasi.store');
    Route::get('/publikasi/edit/{publikasi}', [PublikasiController::class, 'edit'])->name('publikasi.editpublikasi');
    Route::put('/publikasi/update/{publikasi}', [PublikasiController::class, 'update'])->name('publikasi.update');
    Route::delete('/publikasi/hapus/{publikasi}', [PublikasiController::class, 'destroy'])->name('publikasi.destroy');
    
   
    // =======================================================
    Route::get('/publikasi/detail/{id}', [PublikasiController::class, 'show'])
    ->name('publikasi.show');
    // =======================================================

    Route::get('/publikasi/unduh/{id}', [PublikasiController::class, 'unduh'])
    ->name('publikasi.unduh');

    Route::patch('/publikasi/{id}/approve', [PublikasiController::class, 'approve'])->name('publikasi.approve');
    Route::patch('/publikasi/{id}/reject', [PublikasiController::class, 'reject'])->name('publikasi.reject');

});

// profil user
Route::middleware(['auth'])->group(function () {
    // Rute untuk menampilkan halaman profil
    Route::get('/profile', [ProfilController::class, 'show'])->name('profile.show');

    // Rute untuk menyimpan perubahan profil
    Route::post('/profile/update', [ProfilController::class, 'update'])->name('profile.update');
});

