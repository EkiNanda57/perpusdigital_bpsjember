@extends('layouts.sidebar')
@section('content')
<div class="bg-gray-50 flex justify-center items-center min-h-full py-12 px-4">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow p-6 md:p-8">

        <h2 class="text-xl font-semibold mb-6">Edit Profile</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="space-y-4">
                {{-- Nama User --}}
                <div class="flex items-center justify-between bg-gray-100 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 font-bold text-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            {{-- Nama tampil --}}
                            <h3 class="font-semibold text-gray-800" id="displayName">{{ $user->name }}</h3>

                            {{-- Kolom edit nama --}}
                            <input type="text" id="editName" name="name"
                                value="{{ old('name', $user->name) }}"
                                class="hidden border border-gray-300 rounded-lg px-3 py-1 focus:ring focus:ring-blue-200 text-sm"
                            />
                        </div>
                    </div>

                    {{-- Tombol ganti nama --}}
                    <button type="button" id="editButton"
                        class="bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Ganti Nama
                    </button>
                </div>

                {{-- Variabel untuk menampung profil --}}
                @php
                    $profil = null;
                    if ($user->hasRole('Admin')) {
                        $profil = $user->adminProfile;
                    } elseif ($user->hasRole('Operator')) {
                        $profil = $user->operatorProfile;
                    } elseif ($user->hasRole('Pengguna')) {
                        $profil = $user->penggunaProfile;
                    }
                @endphp

                {{-- NIP (untuk semua role) --}}
                <div>
                    <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
                    <input type="text" id="nip" name="nip" maxlength="20" placeholder="Masukkan NIP" value="{{ old('nip', $profil->nip ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"/>
                </div>

                {{-- Jabatan (HANYA untuk Admin) --}}
                @if ($user->hasRole('Admin'))
                <div>
                    <label for="jabatan" class="block text-sm font-semibold text-gray-600">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan"
                            value="{{ old('jabatan', $profil->jabatan ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
                </div>
                @endif

                {{-- NOTIF BERHASIL --}}
                @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Tombol Simpan --}}
                <div class="pt-4">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
    // Cari elemen dengan id 'success-alert'
    const successAlert = document.getElementById('success-alert');

    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = 'none';
        }, 2000);
    }

    const editButton = document.getElementById('editButton');
    const displayName = document.getElementById('displayName');
    const editName = document.getElementById('editName');

    editButton.addEventListener('click', () => {
        if (editName.classList.contains('hidden')) {
            // Ubah ke mode edit
            editName.classList.remove('hidden');
            displayName.classList.add('hidden');
            editButton.textContent = 'Batal';
            editName.focus();
        } else {
            // Kembali ke tampilan semula
            editName.classList.add('hidden');
            displayName.classList.remove('hidden');
            editButton.textContent = 'Ganti Nama';
        }
    });
</script>
@endsection
