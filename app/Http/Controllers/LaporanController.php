<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'total' => Peminjaman::count(),
            'perStatus' => Peminjaman::selectRaw('status, count(*) as jumlah')
                ->groupBy('status')->pluck('jumlah', 'status'),
            'perKategori' => Kategori::withCount('bukus')->orderBy('nama')->get(),
            'terpopuler' => Buku::withCount('peminjamans')
                ->orderByDesc('peminjamans_count')->limit(5)->get(),
            'terbaru' => Peminjaman::with(['anggota', 'buku'])->latest()->limit(20)->get(),
        ]);
    }
}