<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {

        // 🔹 Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:Operator,Pengguna',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Pilih jenis akun Anda.',
            'role.in' => 'Pilihan role tidak valid.',
        ]);

        try {
            // 🔹 Simpan user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 🔹 Cari role berdasarkan input
            $role = Role::where('role_name', $request->role)->first();

            // Jika role tidak ditemukan, tampilkan error
            if (!$role) {
                return back()->withErrors(['registerError' => 'Role tidak ditemukan.'])->withInput();
            }

            // 🔹 Hubungkan user ke role (pastikan relasi sudah ada di model User)
            if (method_exists($user, 'roles')) {
                $user->roles()->attach($role->id);
            }

            // 🔹 Redirect ke halaman login
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}
