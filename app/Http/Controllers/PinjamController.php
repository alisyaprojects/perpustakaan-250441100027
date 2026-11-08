<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class PinjamController extends Controller
{
    public function store(Buku $buku)
    {
        $user = auth()->user();

        // Akun dihubungkan ke data anggota lewat email
        $anggota = Anggota::firstOrCreate(
            ['email' => $user->email],
            ['nama' => $user->name, 'no_telepon' => '-']
        );

        $sudah = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['diajukan', 'dipinjam'])
            ->exists();

        if ($sudah) {
            return back()->withErrors(['pinjam' => 'Buku ini sudah Anda ajukan atau sedang dipinjam.']);
        }

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'diajukan',
        ]);

        return redirect()->route('riwayat.saya')->with('status', 'Pengajuan peminjaman terkirim.');
    }

    public function riwayatSaya()
    {
        return redirect()->route('riwayat.user', auth()->user());
    }

    // Data pribadi: dicek berdasarkan identitas yang login, bukan hanya permission
    public function riwayat(User $user)
    {
        abort_unless($user->id === auth()->id(), 403);

        $anggota = Anggota::where('email', $user->email)->first();

        $pinjams = $anggota
            ? Peminjaman::with('buku')->where('anggota_id', $anggota->id)->latest()->get()
            : collect();

        return view('pinjam.riwayat', compact('pinjams'));
    }
}