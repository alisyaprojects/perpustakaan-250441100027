@extends('layouts.main')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<h1>Riwayat Peminjaman Saya</h1>
@include('partials.flash')

<table class="tabel">
    <tr><th>Buku</th><th>Status</th><th>Tanggal pinjam</th><th>Tanggal kembali</th></tr>
    @forelse ($pinjams as $p)
        <tr>
            <td>{{ $p->buku->judul ?? 'Buku #'.$p->buku_id }}</td>
            <td><span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            <td>{{ $p->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
            <td>{{ $p->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Belum ada riwayat peminjaman.</td></tr>
    @endforelse
</table>
@endsection