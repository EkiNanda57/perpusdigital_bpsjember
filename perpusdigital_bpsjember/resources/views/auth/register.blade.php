@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">Buat Akun Baru ✨</h2>
    <p class="text-sm text-gray-500 text-center">Isi data berikut untuk mendaftar</p>

    @if ($errors->has('registerError'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
        {{ $errors->first('registerError') }}
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      {{-- Nama --}}
      <div>
        <label class="block text-gray-700 font-medium">Nama Lengkap</label>
        <input
          type="text"
          name="name"
          value="{{ old('name') }}"
          placeholder="Nama Lengkap Anda"
          class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none
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
          class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none
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
            class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none
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
        }
        </script>


      {{-- Pilih Jenis Akun --}}
      <div>
        <label class="block text-gray-700 font-medium">Daftar Sebagai</label>
        <select
          name="role"
          class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none
                 @error('status') border-red-500 @enderror"
          required
        >
          <option value="">-- Pilih Jenis Akun --</option>
          <option value="Pengguna" {{ old('role') == 'Pengguna' ? 'selected' : '' }}>Pengguna</option>
          <option value="Operator" {{ old('role') == 'Operator' ? 'selected' : '' }}>Operator</option>
          {{-- <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option> --}}
        </select>
      </div>

      {{-- Tombol Submit --}}
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
        Daftar
      </button>
    </form>

    <p class="text-center text-gray-600 text-sm">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
    </p>
  </div>
</div>
@endsection
