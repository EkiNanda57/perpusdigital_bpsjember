<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KategoriController;

// -- HALAMAN UTAMA --
Route::get('/', function () {
    return view('landingpage');
});

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
});
