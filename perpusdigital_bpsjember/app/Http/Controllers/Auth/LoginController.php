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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔹 Coba login dengan kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower($user->roles->first()->role_name ?? 'pengguna');

            // 🔹 Redirect sesuai role
            if ($role === 'admin') {
                return redirect()->route('dashboard-user.admin-dashboard')->with('success', 'Selamat datang, Admin!');
            } elseif ($role === 'operator') {
                return redirect()->route('dashboard-user.operator-dashboard')->with('success', 'Selamat datang, Operator!');
            } elseif ($role === 'pengguna') {
                return redirect()->route('landingpage')->with('success', 'Selamat datang di Digital Library!');
            }

            // Default redirect
            return redirect()->route('landingpage');
        }

        // Jika gagal login
        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔹 Setelah logout kembali ke landing page
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
