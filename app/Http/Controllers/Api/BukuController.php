<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->cari . '%')
                      ->orWhere('penulis', 'like', '%' . $request->cari . '%');
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->kategori))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->tahun))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => BukuResource::collection($buku->items()),
            'meta' => [
                'current_page'  => $buku->currentPage(),
                'per_page'      => $buku->perPage(),
                'total'         => $buku->total(),
                'last_page'     => $buku->lastPage(),
                'next_page_url' => $buku->nextPageUrl(),
                'prev_page_url' => $buku->previousPageUrl(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            $this->aturan($request),
            $this->pesan($request),
            $this->atribut()
        );

        // Kalau cover dikirim sebagai berkas, simpan berkasnya lalu catat alamatnya
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->simpanGambar($request->file('gambar'));
        }

        $buku = Buku::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => $buku->load('kategori'),
        ], 201);
    }

    public function show(string $id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => $buku], 200);
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate(
            $this->aturan($request, true),
            $this->pesan($request),
            $this->atribut()
        );

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->simpanGambar($request->file('gambar'));
        }

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => $buku->load('kategori'),
        ], 200);
    }

    public function destroy(string $id)
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    /**
     * Aturan validasi. Saat ubah ($ubah = true), tiap aturan diberi 'sometimes'
     * supaya update sebagian tetap lolos (field yang tidak dikirim dilewati).
     */
    private function aturan(Request $request, bool $ubah = false): array
    {
        $aturan = [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
            'deskripsi'    => ['required', 'string'],
            // Berkas gambar (dari form) atau alamat teks (dari Postman)
            'gambar'       => $request->hasFile('gambar')
                ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']
                : ['required', 'string', 'max:255'],
        ];

        if ($ubah) {
            foreach ($aturan as $field => $rule) {
                array_unshift($aturan[$field], 'sometimes');
            }
        }

        return $aturan;
    }

    private function pesan(Request $request): array
    {
        return [
            'required'             => ':attribute wajib diisi.',
            'string'               => ':attribute harus berupa teks.',
            'integer'              => ':attribute harus berupa bilangan bulat.',
            'image'                => ':attribute harus berupa gambar.',
            'judul.string'         => 'Judul buku harus berupa teks.',
            'judul.min'            => 'Judul buku minimal :min karakter',
            'judul.max'            => 'Judul buku maksimal :max karakter.',
            'penulis.min'          => 'Penulis minimal :min karakter.',
            'penulis.max'          => 'Penulis maksimal :max karakter.',
            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'gambar.mimes'         => 'Cover harus berformat JPG, JPEG, PNG, atau WEBP.',
            'gambar.max'           => $request->hasFile('gambar')
                ? 'Ukuran cover maksimal 2 MB.'
                : 'Alamat gambar maksimal :max karakter.',
        ];
    }

    private function atribut(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
            'deskripsi'    => 'deskripsi',
            'gambar'       => 'gambar',
        ];
    }


    private function simpanGambar(UploadedFile $file): string
    {
        $nama = time() . '_' . Str::random(6) . '.' . $file->extension();
        $file->move(public_path('images'), $nama);

        return 'images/' . $nama;
    }
}