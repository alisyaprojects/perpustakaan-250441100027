<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        // Admin dan petugas boleh melihat semua peminjaman
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;
        }

        // Siswa hanya boleh melihat peminjaman miliknya sendiri
        $anggota = Anggota::where('email', $user->email)->first();

        return $anggota !== null && $peminjaman->anggota_id === $anggota->id;
    }
}