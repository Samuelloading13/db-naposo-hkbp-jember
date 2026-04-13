<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MemberController;

// 1. Routes untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// 2. Routes untuk Auth (Sudah Login)
Route::middleware('auth')->group(function () {

    // Tombol Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Halaman Utama (Langsung ke Dashboard Member)
    Route::get('/', [MemberController::class, 'index'])->name('home');

    // Fitur Export (Wajib di atas Resource agar tidak bentrok)
    Route::get('/members/export', [MemberController::class, 'export'])->name('members.export');

    // Otomatis mencakup: index, create, store, show, edit, update, destroy
    Route::resource('members', MemberController::class);

});
