<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Katalog: daftar buku untuk semua role (hanya-baca)
    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->filled('search'), function ($q) use ($request) {
                $kata = $request->search;
                $q->where(function ($w) use ($kata) {
                    $w->where('judul', 'like', "%{$kata}%")
                      ->orWhere('penulis', 'like', "%{$kata}%")
                      ->orWhereHas('kategori', fn ($k) => $k->where('nama', 'like', "%{$kata}%"));
                });
            })
            ->orderBy('judul')
            ->paginate(12)
            ->withQueryString();

        return view('buku.katalog', compact('bukus'));
    }

    // Halaman kelola buku (tambah/ubah/hapus lewat API) untuk admin dan petugas
    public function kelola()
    {
        return view('buku.index', [
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function show($id)
    {
        $item = Buku::with('kategori')->find($id);

        $buku = $item ? [
            'id'           => $item->id,
            'judul'        => $item->judul,
            'penulis'      => $item->penulis,
            'tahun_terbit' => $item->tahun_terbit,
            'kategori'     => $item->kategori->nama,
            'deskripsi'    => $item->deskripsi,
            'gambar'       => $item->gambar ? asset($item->gambar) : null,
        ] : null;

        return view('buku.show', compact('buku'));
    }
}