@extends('layouts.main')

@section('title', 'Registrasi - Perpustakaan Digital')

@section('content')
<div class="auth-card">
    <h2>Registrasi Akun</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="password">Kata Sandi</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @error('password') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

        <button type="submit" class="auth-btn">Register</button>
    </form>

    <p class="auth-link">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</div>
@endsection