@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-orange-100">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">Buat Akun Baru ✨</h2>
    <p class="text-sm text-orange-500 text-center">Isi data berikut untuk mendaftar</p>

    @if ($errors->has('registerError'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
        {{ $errors->first('registerError') }}
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4" id="registerForm">
      @csrf

      {{-- Nama --}}
      <div>
        <label class="block text-gray-700 font-medium">Nama Lengkap</label>
        <input
          type="text"
          name="name"
          value="{{ old('name') }}"
          placeholder="Nama Lengkap Anda"
          class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-orange-200 focus:outline-none
                 @error('name') border-red-500 @enderror"
        >
      </div>

      {{-- Email --}}
      <div>
        <label class="block text-gray-700 font-medium">Email</label>
        <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="contoh: user@gmail.com"
          class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-orange-200 focus:outline-none
                 @error('email') border-red-500 @enderror"
        >
      </div>

      {{-- Password --}}
      <div>
        <label class="block text-gray-700 font-medium">Password</label>
        <div class="relative">
            <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan 8 karakter unik"
            minlength="8"
            class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-orange-200 focus:outline-none
                    @error('password') border-red-500 @enderror"
            >

            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500"
                onclick="togglePassword(event)">
            <!-- Mulai dengan fa-eye-slash karena password awalnya tersembunyi -->
            <i id="eyeIcon" class="fa fa-eye-slash"></i>
            </span>
        </div>
        </div>

        <script>
        function togglePassword(e) {
            // cegah button/span memicu fokus/submit tak sengaja
            if (e) e.preventDefault();

            const password = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (password.type === "password") {
            // ubah jadi terlihat -> tampilkan ikon mata terbuka
            password.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
            } else {
            // ubah jadi tersembunyi -> tampilkan ikon mata tertutup/bergaris
            password.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Pilih semua input di dalam form
                const inputs = document.querySelectorAll('#registerForm input');

                inputs.forEach(input => {
                    input.addEventListener('keydown', function(event) {
                        // Cek jika tombol yang ditekan adalah 'Enter'
                        if (event.key === 'Enter') {
                            // Mencegah perilaku default lain (jika ada)
                            event.preventDefault();
                            // Submit form
                            document.getElementById('registerForm').submit();
                        }
                    });
                });
            });
        }
        </script>


      {{-- Pilih Jenis Akun --}}
      <div>
        <label class="block text-gray-700 font-medium">Daftar Sebagai</label>

        <div
            x-data="{
                open: false,
                selectedRole: '{{ old('role', '') }}',
                get selectedLabel() {
                    if (this.selectedRole === 'Pengguna') return 'Pengguna';
                    if (this.selectedRole === 'Operator') return 'Operator';
                    if (this.selectedRole === 'Admin') return 'Admin';
                    return '-- Pilih Jenis Akun --';
                }
            }"
            class="relative mt-1"
        >

            {{-- BAGIAN INI YANG MENJAGA KONEKSI DATABASE ANDA TETAP AMAN --}}
            {{-- Dia mengirimkan data dengan "name='role'" sama seperti kode lama --}}
            <input type="hidden" name="role" x-model="selectedRole">

            {{-- Ini adalah tombol yang terlihat seperti kotak select --}}
            <button
                type="button"
                @click="open = !open"
                class="w-full px-4 py-2 text-left bg-white border rounded-lg focus:ring focus:ring-orange-200 focus:outline-none flex justify-between items-center"
            >
                <span x-text="selectedLabel"></span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            {{-- Ini adalah daftar pilihan yang bisa diwarnai oranye --}}
            <ul
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute z-10 w-full mt-1 bg-white border rounded-lg shadow-lg"
                style="display: none;"
            >
                {{-- INI PENGGANTI <option> PENGGUNA --}}
                <li
                    class="px-4 py-2 cursor-pointer hover:bg-orange-100 hover:text-orange-800"
                    @click="selectedRole = 'Pengguna'; open = false"
                >
                    Pengguna
                </li>

                {{-- INI PENGGANTI <option> OPERATOR --}}
                <li
                    class="px-4 py-2 cursor-pointer hover:bg-orange-100 hover:text-orange-800"
                    @click="selectedRole = 'Operator'; open = false"
                >
                    Operator
                </li>

                <li
                    class="px-4 py-2 cursor-pointer hover:bg-orange-100 hover:text-orange-800"
                    @click="selectedRole = 'Admin'; open = false"
                >
                    Admin
                </li>
            </ul>

        </div>
        </div>

      {{-- Tombol Submit --}}
      <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition duration-200">
        Daftar
      </button>
    </form>

    <p class="text-center text-gray-600 text-sm">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Masuk di sini</a>
    </p>
  </div>
</div>
@endsection
