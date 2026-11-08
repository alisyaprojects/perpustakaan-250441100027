<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['Admin Perpustakaan',   'admin@perpustakaan.test',   'admin12345',   'admin'],
            ['Petugas Perpustakaan', 'petugas@perpustakaan.test', 'petugas12345', 'petugas'],
            ['Siswa Contoh',         'siswa@perpustakaan.test',   'siswa12345',   'siswa'],
            ['Siswa Kedua',          'siswa2@perpustakaan.test',  'siswa212345',  'siswa'],
        ];

        foreach ($akun as [$nama, $email, $password, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make($password)]
            );

            // Role ditetapkan seeder (mekanisme berwenang), bukan dari formulir
            $user->syncRoles($role);
        }

        // Akun yang dibuat sebelum ada role (mis. akun uji) menjadi siswa
        User::doesntHave('roles')->get()->each->assignRole('siswa');
    }
}