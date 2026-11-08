@extends('layouts.main')

@section('title', 'Login - Perpustakaan Digital')

@section('content')
<div class="auth-card">
    <h2>Login</h2>

    @if (session('status'))
        <p class="auth-status">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email') <p class="auth-error">{{ $message }}</p> @enderror

        <label for="password">Kata Sandi</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        @error('password') <p class="auth-error">{{ $message }}</p> @enderror

        <label class="auth-check"><input type="checkbox" name="remember"> Ingat saya</label>

        <button type="submit" class="auth-btn">Login</button>
    </form>

    <p class="auth-link">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
</div>
@endsection