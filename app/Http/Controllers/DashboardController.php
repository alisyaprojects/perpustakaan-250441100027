<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    // Tujuan setelah login: sesuai role/permission
    public function index()
    {
        $user = auth()->user();

        if ($user->can('akses dashboard admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->can('akses dashboard petugas')) {
            return redirect()->route('petugas.dashboard');
        }
        return redirect()->route('buku.index');
    }

    public function admin()
    {
        return view('dashboard.admin', [
            'jumlahBuku' => Buku::count(),
            'jumlahPengguna' => User::count(),
            'jumlahPengajuan' => Peminjaman::where('status', 'diajukan')->count(),
            'aktivitas' => Peminjaman::with(['anggota', 'buku'])->latest()->limit(5)->get(),
        ]);
    }

    public function petugas()
    {
        return view('dashboard.petugas', [
            'jumlahBuku' => Buku::count(),
            'jumlahPengajuan' => Peminjaman::where('status', 'diajukan')->count(),
            'jumlahDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'aktivitas' => Peminjaman::with(['anggota', 'buku'])->latest()->limit(5)->get(),
        ]);
    }
}