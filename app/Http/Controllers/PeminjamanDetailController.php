<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Gate;

class PeminjamanDetailController extends Controller
{
    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Menggantikan pemeriksaan role/kepemilikan manual dengan Policy
        Gate::authorize('view', $peminjaman);

        return view('pinjam.detail', compact('peminjaman'));
    }
}