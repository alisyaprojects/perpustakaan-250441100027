<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PeminjamanDetailController extends Controller
{
    public function show($id)
    {
        // RENTAN: tidak ada pemeriksaan pemilik (IDOR)
        $peminjaman = Peminjaman::findOrFail($id);

        return view('pinjam.detail', compact('peminjaman'));
    }
}