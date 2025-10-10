<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('landingpage');
});


// CRUD kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.kategori');
Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.addkategori');
Route::post('/kategori/simpan', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('kategori.editkategori');
Route::put('/kategori/update/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/hapus/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');