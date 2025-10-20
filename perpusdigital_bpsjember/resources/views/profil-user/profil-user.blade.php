@extends('layouts.sidebar')
@section('content')
<div class="bg-gray-50 flex justify-center items-center min-h-full py-12 px-4">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow p-6 md:p-8">

        <h2 class="text-xl font-semibold mb-6 text-center md:text-center">Edit Profile</h2>

        <!-- Foto Profil -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 text-3xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="space-y-4">

                {{-- NAMA LENGKAP --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-2 border-orange-400 rounded-xl p-4">
                    <div class="flex items-center gap-2 sm:gap-4 flex-1">
                        <span class="text-sm text-black-500 w-28">Nama Lengkap</span>
                        <div class="flex-1">
                            <h3 id="displayName" class="font-semibold text-gray-800 truncate">{{ $user->name }}</h3>
                            <input type="text" id="editName" name="name"
                                value="{{ old('name', $user->name) }}"
                                class="hidden bg-transparent outline-none w-full"
                            />
                        </div>
                    </div>

                    <button type="button" id="editButton"
                        class="mt-3 sm:mt-0 text-orange-500 hover:text-orange-600 transition p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232a3 3 0 014.243 4.243L7.5 21.25H3.75v-3.75L15.232 5.232z" />
                        </svg>
                    </button>
                </div>

                {{-- NIP --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-2 border-orange-400 rounded-xl p-4">
                    <div class="flex items-center gap-2 sm:gap-4 flex-1">
                        <span class="text-sm text-black-500 w-28">NIP</span>
                        <div class="flex-1">
                            <p id="displayNip" class="font-semibold text-gray-800 truncate">
                                {{ $profil->nip ?? 'Belum diisi' }}
                            </p>
                            <input type="text" id="nip" name="nip" maxlength="20"
                                value="{{ old('nip', $profil->nip ?? '') }}"
                                class="hidden bg-transparent outline-none w-full"
                            />
                        </div>
                    </div>

                    <button type="button" id="editNipButton"
                        class="mt-3 sm:mt-0 text-orange-500 hover:text-orange-600 transition p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232a3 3 0 014.243 4.243L7.5 21.25H3.75v-3.75L15.232 5.232z" />
                        </svg>
                    </button>
                </div>

                {{-- JABATAN --}}
                @if ($user->hasRole('Admin'))
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-2 border-orange-400 rounded-xl p-4">
                        <div class="flex items-center gap-2 sm:gap-4 flex-1">
                            <span class="text-sm text-black-500 w-28">Jabatan</span>
                            <div class="flex-1">
                                <p id="displayJabatan" class="font-semibold text-gray-800 truncate">
                                    {{ $profil->jabatan ?? 'Belum diisi' }}
                                </p>
                                <input type="text" id="jabatan" name="jabatan"
                                    value="{{ old('jabatan', $profil->jabatan ?? '') }}"
                                    class="hidden bg-transparent outline-none w-full"
                                />
                            </div>
                        </div>

                        <button type="button" id="editJabatanButton"
                            class="mt-3 sm:mt-0 text-orange-500 hover:text-orange-600 transition p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232a3 3 0 014.243 4.243L7.5 21.25H3.75v-3.75L15.232 5.232z" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- NOTIFIKASI --}}
                @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center sm:text-left">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- SIMPAN --}}
                <div class="pt-4">
                    <button type="submit" class="w-full px-4 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const successAlert = document.getElementById('success-alert');
    if (successAlert) setTimeout(() => successAlert.style.display = 'none', 2000);

    // 🖊️ Ikon pensil
    const pencilIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.232 5.232a3 3 0 014.243 4.243L7.5 21.25H3.75v-3.75L15.232 5.232z" />
        </svg>
    `;

    // ✅ Ikon centang
    const checkIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block text-green-600" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7" />
        </svg>
    `;

    // 🔧 Fungsi umum agar semua field bisa edit & preview tanpa simpan
    function setupEditableField(displayId, inputId, buttonId) {
        const displayEl = document.getElementById(displayId);
        const inputEl = document.getElementById(inputId);
        const buttonEl = document.getElementById(buttonId);

        buttonEl.addEventListener('click', () => {
            const isEditing = !inputEl.classList.contains('hidden');

            if (isEditing) {
                // 🔸 Klik ikon centang → ubah teks tampilan sementara
                displayEl.textContent = inputEl.value || 'Belum diisi';
                inputEl.classList.add('hidden');
                displayEl.classList.remove('hidden');
                buttonEl.innerHTML = pencilIcon;
            } else {
                // 🔸 Klik ikon pensil → aktifkan input
                inputEl.classList.remove('hidden');
                displayEl.classList.add('hidden');
                buttonEl.innerHTML = checkIcon;

                inputEl.focus();
                inputEl.selectionStart = inputEl.value.length;
            }
        });
    }

    // 🟠 Terapkan ke setiap kolom
    setupEditableField('displayName', 'editName', 'editButton');
    setupEditableField('displayNip', 'nip', 'editNipButton');
    if (document.getElementById('editJabatanButton')) {
        setupEditableField('displayJabatan', 'jabatan', 'editJabatanButton');
    }
</script>

@endsection
