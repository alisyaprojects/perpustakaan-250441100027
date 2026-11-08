@extends('layouts.main')

@section('title', 'Detail Peminjaman')

@section('content')
<h1>Detail Peminjaman #{{ $peminjaman->id }}</h1>
<table class="tabel">
    <tr><th>Anggota</th><td>{{ $peminjaman->anggota->nama ?? '-' }}</td></tr>
    <tr><th>Buku</th><td>{{ $peminjaman->buku->judul ?? '-' }}</td></tr>
    <tr><th>Status</th><td>{{ $peminjaman->status }}</td></tr>
    <tr><th>Tanggal pinjam</th><td>{{ $peminjaman->tanggal_pinjam }}</td></tr>
</table>
@endsection