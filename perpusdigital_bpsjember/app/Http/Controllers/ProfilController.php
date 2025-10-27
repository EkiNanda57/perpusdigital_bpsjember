<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminProfile;

class ProfilController extends Controller
{
    public function show()
    {
        $name = \Auth::check() ? \Auth::user()->name : 'Nama Pengguna';

        $user = Auth::user();
        $user->refresh();

        $profil = null;
        if ($user->hasRole('Admin')) {
            $profil = \App\Models\AdminProfil::where('user_id', $user->id)->first();
        } elseif ($user->hasRole('Operator')) {
            $profil = \App\Models\OperatorProfil::where('user_id', $user->id)->first();
        } elseif ($user->hasRole('Pengguna')) {
            $profil = \App\Models\PenggunaProfil::where('user_id', $user->id)->first();
        }

        return view('profil-user.profil-user', compact('user', 'profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:18',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        if ($request->filled('name')) {
            $user->name = $request->name;
            $user->save();
        }

        $dataProfil = [];


        if ($request->filled('nip')) {
            $dataProfil['nip'] = $request->nip;
        }

        if ($request->filled('jabatan')) {
            $dataProfil['jabatan'] = $request->jabatan;
        }

        if (!empty($dataProfil)) {
            if ($user->hasRole('Admin')) {
                \App\Models\AdminProfil::updateOrCreate(
                    ['user_id' => $user->id],
                    $dataProfil
                );
            } elseif ($user->hasRole('Operator')) {
                if(isset($dataProfil['nip'])) {
                     \App\Models\OperatorProfil::updateOrCreate(
                        ['user_id' => $user->id],
                        ['nip' => $dataProfil['nip']]
                    );
                }
            } elseif ($user->hasRole('Pengguna')) {
                // Sama seperti operator
                 if(isset($dataProfil['nip'])) {
                    \App\Models\PenggunaProfil::updateOrCreate(
                        ['user_id' => $user->id],
                        ['nip' => $dataProfil['nip']]
                    );
                }
            }
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
