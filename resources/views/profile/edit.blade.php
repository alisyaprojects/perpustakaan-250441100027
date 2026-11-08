@extends('layouts.main')

@section('title', 'Profil - Perpustakaan Digital')

@section('content')
<div class="auth-card">
    <h2>Profil Saya</h2>

    @if (session('status') === 'profile-updated')
        <p class="auth-status">Profil berhasil diperbarui.</p>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email') <p class="auth-error">{{ $message }}</p> @enderror

        <button type="submit" class="auth-btn">Simpan Profil</button>
    </form>
</div>

<div class="auth-card">
    <h2>Ubah Kata Sandi</h2>

    @if (session('status') === 'password-updated')
        <p class="auth-status">Kata sandi berhasil diubah.</p>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <label for="current_password">Kata Sandi Saat Ini</label>
        <input id="current_password" type="password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="new_password">Kata Sandi Baru</label>
        <input id="new_password" type="password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
        <input id="new_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">

        <button type="submit" class="auth-btn">Ubah Kata Sandi</button>
    </form>
</div>
@endsection