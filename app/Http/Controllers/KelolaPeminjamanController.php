<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class KelolaPeminjamanController extends Controller
{
    public function peminjaman()
    {
        return view('kelola.peminjaman', [
            'pinjams' => Peminjaman::with(['anggota', 'buku'])->latest()->get(),
        ]);
    }

    public function setujui(Peminjaman $pinjam)
    {
        abort_unless($pinjam->status === 'diajukan', 422);

        $pinjam->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => now()->toDateString(),
            'diproses_oleh' => auth()->id(),
        ]);

        return back()->with('status', 'Peminjaman disetujui.');
    }

    public function tolak(Peminjaman $pinjam)
    {
        abort_unless($pinjam->status === 'diajukan', 422);

        $pinjam->update(['status' => 'ditolak', 'diproses_oleh' => auth()->id()]);

        return back()->with('status', 'Peminjaman ditolak.');
    }

    public function pengembalian()
    {
        return view('kelola.pengembalian', [
            'pinjams' => Peminjaman::with(['anggota', 'buku'])
                ->whereIn('status', ['dipinjam', 'dikembalikan'])->latest()->get(),
        ]);
    }

    public function kembali(Peminjaman $pinjam)
    {
        abort_unless($pinjam->status === 'dipinjam', 422);

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
            'diproses_oleh' => auth()->id(),
        ]);

        return back()->with('status', 'Pengembalian buku dicatat.');
    }
}