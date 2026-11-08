@extends('layouts.main')

@section('title', 'Data Peminjaman')

@section('content')
<h1>Data Peminjaman</h1>
@include('partials.flash')

<table class="tabel">
    <tr><th>Anggota</th><th>Buku</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
    @forelse ($pinjams as $p)
        <tr>
            <td>{{ $p->anggota->nama ?? '-' }}</td>
            <td>{{ $p->buku->judul ?? 'Buku #'.$p->buku_id }}</td>
            <td><span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
            <td>
                @if ($p->status === 'diajukan')
                    @can('memproses persetujuan peminjaman')
                        <form class="inline" method="POST" action="{{ route('kelola.peminjaman.setujui', $p) }}">
                            @csrf <button class="btn-kecil" type="submit">Setujui</button>
                        </form>
                        <form class="inline" method="POST" action="{{ route('kelola.peminjaman.tolak', $p) }}">
                            @csrf <button class="btn-kecil btn-merah" type="submit">Tolak</button>
                        </form>
                    @endcan
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5">Belum ada data peminjaman.</td></tr>
    @endforelse
</table>
@endsection