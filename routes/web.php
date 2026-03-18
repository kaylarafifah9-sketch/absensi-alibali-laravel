<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;

// Login
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Absensi Karyawan
Route::get('/absensi', [AbsensiController::class, 'index']);
Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk']);
Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang']);
Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat']);

// Admin
Route::get('/admin/dashboard', [AdminController::class, 'index']);