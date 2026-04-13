<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendaftarkan semua rute untuk aplikasi Database Naposo.
|
*/

// 1. Halaman Utama: Menampilkan daftar anggota & notifikasi ulang tahun
Route::get('/', [MemberController::class, 'index'])->name('members.index');

// 2. Fitur Tambah Data: Form input manual
Route::post('/member', [MemberController::class, 'store'])->name('members.store');

// 3. Fitur Rincian: Melihat detail lengkap per anggota
Route::get('/member/{id}', [MemberController::class, 'show'])->name('members.show');

// 4. Fitur Update: Menyimpan perubahan data anggota
Route::put('/member/{id}', [MemberController::class, 'update'])->name('members.update');

// 5. Fitur Hapus: Menghapus anggota dari database
Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

// 6. Fitur Import Excel: Mengunggah file database dari Excel
Route::post('/import', [MemberController::class, 'import'])->name('members.import');
