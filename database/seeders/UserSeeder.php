<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            // Password admin diambil dari .env, bukan ditulis langsung di kode.
            // Kalau ADMIN_SEED_PASSWORD tidak diisi, dibuat acak sehingga password lama tidak berlaku.
            ['Admin Perpustakaan',   'admin@perpustakaan.test',   env('ADMIN_SEED_PASSWORD', Str::random(20)), 'admin'],
            ['Petugas Perpustakaan', 'petugas@perpustakaan.test', 'petugas12345', 'petugas'],
            ['Siswa Contoh',         'siswa@perpustakaan.test',   'siswa12345',   'siswa'],
            ['Siswa Kedua',          'siswa2@perpustakaan.test',  'siswa212345',  'siswa'],
        ];

        foreach ($akun as [$nama, $email, $password, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make($password)]
            );

            $user->syncRoles($role);
        }

        User::doesntHave('roles')->get()->each->assignRole('siswa');
    }
}

