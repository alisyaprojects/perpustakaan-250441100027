<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelolaPeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuCariController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Semua di bawah ini wajib login (middleware auth)
Route::middleware('auth')->group(function () {

    // Dashboard: /dashboard mengarahkan sesuai role
    Route::get('/buku-cari', [BukuCariController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses dashboard admin')->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses dashboard petugas')->name('petugas.dashboard');

    // Daftar dan detail buku (semua role)
    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
    });

    // Pengajuan peminjaman
    Route::post('/buku/{buku}/pinjam', [PinjamController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')->name('pinjam.store');

    // Status dan riwayat milik sendiri
    Route::middleware('permission:melihat riwayat peminjaman sendiri|melihat status peminjaman sendiri')
        ->group(function () {
            Route::get('/riwayat', [PinjamController::class, 'riwayatSaya'])->name('riwayat.saya');
            Route::get('/riwayat/{user}', [PinjamController::class, 'riwayat'])->name('riwayat.user');
        });

    // Profil (data milik sendiri: controller memakai $request->user())
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');

    // Operasional: admin dan petugas
    Route::prefix('kelola')->name('kelola.')->group(function () {
        Route::get('/buku', [BukuController::class, 'kelola'])
            ->middleware('permission:kelola data buku')->name('buku.index');

        Route::get('/peminjaman', [KelolaPeminjamanController::class, 'peminjaman'])
            ->middleware('permission:kelola peminjaman')->name('peminjaman');
        Route::post('/peminjaman/{pinjam}/setujui', [KelolaPeminjamanController::class, 'setujui'])
            ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.setujui');
        Route::post('/peminjaman/{pinjam}/tolak', [KelolaPeminjamanController::class, 'tolak'])
            ->middleware('permission:memproses persetujuan peminjaman')->name('peminjaman.tolak');

        Route::get('/pengembalian', [KelolaPeminjamanController::class, 'pengembalian'])
            ->middleware('permission:kelola pengembalian')->name('pengembalian');
        Route::post('/pengembalian/{pinjam}', [KelolaPeminjamanController::class, 'kembali'])
            ->middleware('permission:mencatat pengembalian buku')->name('pengembalian.catat');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')->name('laporan');

    // Khusus admin: pengguna dan role
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/pengguna', [UserManagementController::class, 'index'])
            ->middleware('permission:kelola data pengguna')->name('pengguna.index');
        Route::post('/pengguna', [UserManagementController::class, 'store'])
            ->middleware('permission:kelola data pengguna')->name('pengguna.store');
        Route::patch('/pengguna/{user}/role', [UserManagementController::class, 'updateRole'])
            ->middleware('permission:kelola role pengguna')->name('pengguna.role');
    });
});

require __DIR__.'/auth.php';