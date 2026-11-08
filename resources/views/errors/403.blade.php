@extends('layouts.main')

@section('title', 'Akses Ditolak')

@section('content')
<div class="auth-card" style="text-align: center;">
    <h2>403 - Akses Ditolak</h2>
    <p>Anda tidak memiliki hak akses untuk membuka halaman ini.</p>
    <p><a href="{{ route('home') }}">Kembali ke beranda</a></p>
</div>
@endsection