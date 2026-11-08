<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Digital')</title>

    @vite(['resources/css/perpustakaan.css'])
</head>
<body>
<header class="nav-atas">
    <div class="nav-wadah">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="nav-brand">
            <span>Perpustakaan Digital</span>
        </a>

        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-burger" aria-label="Menu"><x-ikon nama="menu" /></label>

        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'aktif' : '' }}">Beranda</a>

            @auth
                @canany(['akses dashboard admin', 'akses dashboard petugas'])
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard', 'admin.dashboard', 'petugas.dashboard') ? 'aktif' : '' }}">Dashboard</a>
                @endcanany

                @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" class="nav-link {{ request()->routeIs('buku.*') ? 'aktif' : '' }}">Daftar Buku</a>
                @endcan

                @role('siswa')
                    <a href="{{ route('riwayat.saya') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'aktif' : '' }}">Riwayat Saya</a>
                @endrole

                @canany(['kelola data buku', 'kelola peminjaman', 'kelola pengembalian', 'lihat laporan perpustakaan'])
                    <div class="nav-drop">
                        <button type="button" class="nav-link nav-trigger {{ request()->routeIs('kelola.*', 'laporan') ? 'aktif' : '' }}">
                            Operasional <x-ikon nama="chevron" />
                        </button>
                        <div class="nav-panel">
                            @can('kelola-buku')
                                <a href="{{ route('kelola.buku.index') }}">Kelola Buku</a>
                            @endcan
                            @can('kelola peminjaman')
                                <a href="{{ route('kelola.peminjaman') }}">Peminjaman</a>
                            @endcan
                            @can('kelola pengembalian')
                                <a href="{{ route('kelola.pengembalian') }}">Pengembalian</a>
                            @endcan
                            @can('lihat laporan perpustakaan')
                                <a href="{{ route('laporan') }}">Laporan</a>
                            @endcan
                        </div>
                    </div>
                @endcanany

                @can('kelola data pengguna')
                    <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'aktif' : '' }}">Pengguna</a>
                @endcan

                <div class="nav-drop nav-user">
                    <button type="button" class="nav-link nav-trigger">
                        <span class="nav-avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="nav-nama">{{ auth()->user()->name }}</span>
                        <x-ikon nama="chevron" />
                    </button>
                    <div class="nav-panel nav-panel-kanan">
                        <div class="nav-info">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span class="nav-peran">{{ auth()->user()->getRoleNames()->first() }}</span>
                        </div>
                        @can('lihat profil sendiri')
                            <a href="{{ route('profile.edit') }}">Profil Saya</a>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}" class="nav-keluar">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link nav-kanan {{ request()->routeIs('login') ? 'aktif' : '' }}">Login</a>
                <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'aktif' : '' }}">Register</a>
            @endauth
        </nav>
    </div>
</header>

<main class="app-content page">
    @yield('content')
</main>

<footer class="app-footer">
    &copy; {{ date('Y') }} Perpustakaan Digital
</footer>
</body>
</html>

