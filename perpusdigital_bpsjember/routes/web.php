<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PenggunaController;

// -- HALAMAN UTAMA --
Route::get('/', function () {
    return view('landingpage');
});

// -- LOGIN & REGISTER --
// login
// login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -- DASHBOARD (DENGAN CONTROLLER MASING-MASING) --
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
Route::get('/pengguna/dashboard', [PenggunaController::class, 'index'])->name('pengguna.dashboard');
