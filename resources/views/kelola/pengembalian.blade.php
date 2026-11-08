@extends('layouts.main')

@section('title', 'Data Pengembalian')

@section('content')
<h1>Data Pengembalian</h1>
@include('partials.flash')

<table class="tabel">
    <tr><th>Anggota</th><th>Buku</th><th>Status</th><th>Tanggal pinjam</th><th>Tanggal kembali</th><th>Aksi</th></tr>
    @forelse ($pinjams as $p)
        <tr>
            <td>{{ $p->anggota->nama ?? '-' }}</td>
            <td>{{ $p->buku->judul ?? 'Buku #'.$p->buku_id }}</td>
            <td><span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
            <td>{{ $p->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
            <td>
                @if ($p->status === 'dipinjam')
                    @can('mencatat pengembalian buku')
                        <form class="inline" method="POST" action="{{ route('kelola.pengembalian.catat', $p) }}">
                            @csrf <button class="btn-kecil" type="submit">Catat Pengembalian</button>
                        </form>
                    @endcan
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="6">Belum ada data.</td></tr>
    @endforelse
</table>
@endsection