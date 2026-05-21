<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;

Route::get('/', fn() => redirect()->route('dashboard'));

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Mahasiswa CRUD
Route::resource('mahasiswa', MahasiswaController::class);

// Mahasiswa exports & kartu
Route::get('/mahasiswa/export/excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export.excel');
Route::get('/mahasiswa/export/pdf',   [MahasiswaController::class, 'exportPdf'])->name('mahasiswa.export.pdf');
Route::get('/mahasiswa/{mahasiswa}/kartu', [MahasiswaController::class, 'kartu'])->name('mahasiswa.kartu');

// Program Studi
Route::resource('prodi', ProdiController::class)->only(['index', 'store', 'update', 'destroy']);

// About
Route::get('/about', fn() => view('about.index'))->name('about');
