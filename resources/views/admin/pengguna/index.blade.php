@extends('layouts.main')

@section('title', 'Kelola Pengguna dan Role')

@section('content')
<h1>Kelola Pengguna dan Role</h1>
@include('partials.flash')

<h2>Tambah Akun</h2>
<form method="POST" action="{{ route('admin.pengguna.store') }}" class="form-baris">
    @csrf
    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Kata sandi (min. 8)" required>
    <select name="role">
        @foreach ($roles as $r)
            <option value="{{ $r }}">{{ $r }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-kecil">Buat Akun</button>
</form>

<h2>Daftar Pengguna</h2>
<table class="tabel">
    <tr><th>Nama</th><th>Email</th><th>Role</th><th>Ubah Role</th></tr>
    @foreach ($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->getRoleNames()->implode(', ') ?: '-' }}</td>
            <td>
                @can('kelola role pengguna')
                    <form class="inline form-baris" method="POST" action="{{ route('admin.pengguna.role', $u) }}">
                        @csrf
                        @method('PATCH')
                        <select name="role">
                            @foreach ($roles as $r)
                                <option value="{{ $r }}" @selected($u->hasRole($r))>{{ $r }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-kecil">Simpan</button>
                    </form>
                @endcan
            </td>
        </tr>
    @endforeach
</table>
@endsection