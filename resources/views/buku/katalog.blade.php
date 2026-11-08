@extends('layouts.main')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
    <h2 class="judul-hal">Daftar Buku</h2>

    @include('partials.flash')

    <form method="GET" action="{{ route('buku.index') }}" class="bar-cari">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau kategori...">
        <button type="submit" class="btn-kecil">Cari</button>
        @if (request('search'))
            <a href="{{ route('buku.index') }}">Tampilkan semua</a>
        @endif
    </form>

    <div class="grid-buku">
        @forelse ($bukus as $b)
            <div class="card kartu-buku">
                <div class="cover">
                    @if ($b->gambar)
                        <img src="{{ asset($b->gambar) }}" alt="{{ $b->judul }}">
                    @endif
                </div>
                <span class="badge">{{ $b->kategori->nama ?? '-' }}</span>
                <h3>{{ $b->judul }}</h3>
                <p class="penulis">{{ $b->penulis }} &middot; {{ $b->tahun_terbit }}</p>

                <div class="aksi-kartu">
                    <a class="btn-kecil" href="{{ route('buku.show', $b->id) }}">Detail</a>
                    @can('mengajukan peminjaman buku')
                        <form method="POST" action="{{ route('pinjam.store', $b->id) }}">
                            @csrf
                            <button type="submit" class="btn-kecil">Ajukan Pinjam</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p>Belum ada buku.</p>
        @endforelse
    </div>

    <div class="bar-hal">
        @if ($bukus->previousPageUrl())
            <a class="btn-kecil" href="{{ $bukus->previousPageUrl() }}">&larr; Sebelumnya</a>
        @else
            <span></span>
        @endif

        <span>Halaman {{ $bukus->currentPage() }} dari {{ $bukus->lastPage() }}</span>

        @if ($bukus->nextPageUrl())
            <a class="btn-kecil" href="{{ $bukus->nextPageUrl() }}">Berikutnya &rarr;</a>
        @else
            <span></span>
        @endif
    </div>
@endsection