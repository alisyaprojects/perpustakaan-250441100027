<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.index', [
            'users' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::pluck('name'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,petugas,siswa'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->syncRoles($data['role']);

        return back()->with('status', "Akun {$user->name} dibuat dengan role {$data['role']}.");
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,petugas,siswa'],
        ]);

        // Admin tidak boleh menurunkan role akunnya sendiri
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Role akun sendiri tidak dapat diubah.']);
        }

        $user->syncRoles($data['role']);

        return back()->with('status', "Role {$user->name} diubah menjadi {$data['role']}.");
    }
}