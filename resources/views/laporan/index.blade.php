@extends('layouts.main')

@section('title', 'Laporan Perpustakaan')

@section('content')
@php
    $maxKat = max(1, $perKategori->max('bukus_count'));
    $maxPop = max(1, $terpopuler->max('peminjamans_count'));
@endphp
<div class="hal-laporan">
    <h1>Laporan Perpustakaan</h1>

    <div class="stat-grid-kecil">
        <div class="stat-mini"><b>{{ $total }}</b><span>Total transaksi</span></div>
        @foreach (['diajukan', 'dipinjam', 'dikembalikan', 'ditolak'] as $s)
            <div class="stat-mini s-{{ $s }}"><b>{{ $perStatus[$s] ?? 0 }}</b><span>{{ ucfirst($s) }}</span></div>
        @endforeach
    </div>

    <h2>Jumlah buku per kategori</h2>
    <table class="tabel">
        <tr><th>Kategori</th><th></th><th class="angka">Jumlah</th></tr>
        @foreach ($perKategori as $k)
            <tr>
                <td>{{ $k->nama }}</td>
                <td class="batang"><span style="width: {{ round($k->bukus_count / $maxKat * 100) }}%"></span></td>
                <td class="angka">{{ $k->bukus_count }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Buku paling sering dipinjam</h2>
    <table class="tabel">
        <tr><th>Judul</th><th></th><th class="angka">Dipinjam</th></tr>
        @forelse ($terpopuler as $b)
            <tr>
                <td>{{ $b->judul }}</td>
                <td class="batang"><span style="width: {{ round($b->peminjamans_count / $maxPop * 100) }}%"></span></td>
                <td class="angka">{{ $b->peminjamans_count }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Belum ada data.</td></tr>
        @endforelse
    </table>

    <h2>Transaksi terbaru</h2>
    <table class="tabel">
        <tr><th>Anggota</th><th>Buku</th><th>Status</th></tr>
        @forelse ($terbaru as $p)
            <tr>
                <td>{{ $p->anggota->nama ?? '-' }}</td>
                <td>{{ $p->buku->judul ?? 'Buku #'.$p->buku_id }}</td>
                <td><span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            </tr>
        @empty
            <tr><td colspan="3">Belum ada transaksi.</td></tr>
        @endforelse
    </table>
</div>
@endsection