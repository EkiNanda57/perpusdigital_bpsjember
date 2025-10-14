@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">
    <h2 class="text-2xl font-bold text-center text-gray-800">Selamat Datang 👋</h2>
    <p class="text-sm text-gray-500 text-center">Silakan masuk ke akunmu</p>


    @if (session('success'))
    <div id="successAlert"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center transform transition-all duration-700">
    {{ session('success') }}
    </div>
    <script>
    // hilangkan otomatis setelah 3 detik (3000 ms)
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 700);
            }
            }, 1000);
    </script>
    @endif

    @if ($errors->has('loginError'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
        {{ $errors->first('loginError') }}
    </div>
    @endif

    {{-- FORM LOGIN --}}
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf

      {{-- EMAIL --}}
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
        @error('email')
          <p class="text-sm text-red-500 mt-1">Wajib diisi</p>
        @enderror
      </div>

      {{-- PASSWORD --}}
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

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
        Masuk
      </button>
    </form>

    <p class="text-center text-gray-600 text-sm">
      Belum punya akun?
      <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
    </p>
  </div>
</div>
@endsection
