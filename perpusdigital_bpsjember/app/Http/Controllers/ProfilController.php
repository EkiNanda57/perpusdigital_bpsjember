<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminProfile;

class ProfilController extends Controller
{
    public function show()
    {
        // Ambil nama user dari Auth; kalau tidak ada, pakai fallback
        $name = \Auth::check() ? \Auth::user()->name : 'Nama Pengguna';
        $user = \Auth::user();
        return view('profil-user.profil-user', compact('user'));
    }

    public function update(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:18', // Ubah ke string agar bisa menampung NIP panjang
            'jabatan' => 'nullable|string|max:100',
        ]);

        // 2. Ambil User yang Sedang Login
        $user = Auth::user();
        if ($request->filled('name')) {
            $user->name = $request->name;
            $user->save();
        }

        // 3. Simpan atau Update Profil Sesuai Role
        if ($user->hasRole('Admin')) {
            \App\Models\AdminProfil::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->nip,
                    'jabatan' => $request->jabatan
                ]
            );
        } elseif ($user->hasRole('Operator')) {
            \App\Models\OperatorProfil::updateOrCreate(
                ['user_id' => $user->id],
                ['nip' => $request->nip]
            );
        } elseif ($user->hasRole('Pengguna')) {
            \App\Models\PenggunaProfil::updateOrCreate(
                ['user_id' => $user->id],
                ['nip' => $request->nip]
            );
        }

        // 4. Redirect Kembali dengan Pesan Sukses
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
