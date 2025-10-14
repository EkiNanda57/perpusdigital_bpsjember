<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 🔹 Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔹 Cari user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        // 🔹 Cek apakah user ditemukan
        if ($user && \Hash::check($request->password, $user->password)) {
            // Login manual (bypass Auth::attempt)
            \Auth::login($user);

            // 🔹 Redirect sesuai role
            if ($user->hasRole('Admin')) {
                return redirect()->route('dashboard-user.admin-dashboard')->with('success', 'Selamat datang, Admin!');
            } elseif ($user->hasRole('Operator')) {
                return redirect()->route('operator.dashboard')->with('success', 'Selamat datang, Operator!');
            } elseif ($user->hasRole('Pengguna')) {
                return redirect()->route('pengguna.dashboard')->with('success', 'Selamat datang, Pengguna!');
            }

            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['loginError' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
