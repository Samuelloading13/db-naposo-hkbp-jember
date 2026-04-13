<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;

// Pastikan ada Route::get untuk menampilkan daftar anggota
Route::middleware('auth')->group(function () {
    // Menampilkan Dashboard & Daftar Anggota
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');

    // Menampilkan Form Tambah
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');

    // Proses Simpan (Ini yang pakai POST)
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');

    // Menampilkan Detail & Edit
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');

    // Proses Update (Pakai PUT/PATCH)
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');

    // Proses Hapus (Pakai DELETE)
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
});
