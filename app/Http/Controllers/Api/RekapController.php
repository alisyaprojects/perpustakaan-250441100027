<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        $data = DB::table('kategoris')
            ->leftJoin('bukus', 'bukus.kategori_id', '=', 'kategoris.id')
            ->select(
                'kategoris.id',
                'kategoris.nama',
                DB::raw('COUNT(bukus.id) as jumlah_buku')
            )
            ->groupBy('kategoris.id', 'kategoris.nama')
            ->orderBy('kategoris.id')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function peminjamanPerBuku()
    {
        $data = Buku::select('id', 'judul')
            ->withCount('peminjamans as total_peminjaman')
            ->orderByDesc('total_peminjaman')
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $data], 200);
    }
}
