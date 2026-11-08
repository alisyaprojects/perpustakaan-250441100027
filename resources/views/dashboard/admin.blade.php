@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<h1>Dashboard Admin</h1>
<p class="sapaan">Selamat datang, {{ auth()->user()->name }}.</p>

<div class="stat-grid">
    <div class="stat-card"><div class="angka">{{ $jumlahBuku }}</div><div class="label">Jumlah buku</div></div>
    <div class="stat-card"><div class="angka">{{ $jumlahPengguna }}</div><div class="label">Jumlah pengguna</div></div>
    <div class="stat-card s-diajukan"><div class="angka">{{ $jumlahPengajuan }}</div><div class="label">Pengajuan menunggu</div></div>
</div>

<h2>Menu</h2>
<div class="ubin-grid">
    @can('kelola data pengguna')
        <a class="ubin" href="{{ route('admin.pengguna.index') }}"><b>Kelola Pengguna</b><span>Akun dan role</span></a>
    @endcan
    @can('kelola data buku')
        <a class="ubin" href="{{ route('kelola.buku.index') }}"><b>Kelola Buku</b><span>Tambah, ubah, hapus</span></a>
    @endcan
    @can('kelola peminjaman')
        <a class="ubin" href="{{ route('kelola.peminjaman') }}"><b>Peminjaman</b><span>Setujui pengajuan</span></a>
    @endcan
    @can('kelola pengembalian')
        <a class="ubin" href="{{ route('kelola.pengembalian') }}"><b>Pengembalian</b><span>Catat buku kembali</span></a>
    @endcan
    @can('lihat laporan perpustakaan')
        <a class="ubin" href="{{ route('laporan') }}"><b>Laporan</b><span>Ringkasan data</span></a>
    @endcan
</div>

<h2>Aktivitas terbaru</h2>
@if ($aktivitas->isEmpty())
    <p class="sapaan">Belum ada aktivitas.</p>
@else
    <table class="tabel">
        <tr><th>Anggota</th><th>Buku</th><th>Status</th></tr>
        @foreach ($aktivitas as $p)
            <tr>
                <td>{{ $p->anggota->nama ?? '-' }}</td>
                <td>{{ $p->buku->judul ?? 'Buku #'.$p->buku_id }}</td>
                <td><span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            </tr>
        @endforeach
    </table>
@endif
@can('lihat laporan perpustakaan')
    <a class="lihat-semua" href="{{ route('laporan') }}">Lihat laporan lengkap</a>
@endcan
@endsection