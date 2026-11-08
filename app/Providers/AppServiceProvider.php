<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pusat aturan pengelolaan buku: hanya admin dan petugas
        Gate::define('kelola-buku', function ($user) {
            return $user->hasAnyRole(['admin', 'petugas']);
        });
    }
}