<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Publikasi')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar Atas -->
    <header class="bg-white shadow py-4 px-6 flex justify-between items-center">
        <a href="{{ route('landingpage') }}" class="flex items-center space-x-3 hover:opacity-90 transition">
            <img src="{{ asset('logo/logose.png') }}" alt="Logo" class="w-10 h-10 object-contain">
            <h1 class="text-2xl font-bold text-orange-500">Perpustakaan</h1>
        </a>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-gray-700 font-medium">
                    Halo, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->roles->first()->role_name ?? 'Pengguna') }})
                </span>
                <div class="relative">
                    <button id="profile-menu-button"
                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 focus:outline-none">
                        <span class="font-bold text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </button>
                    <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <!-- Konten Halaman -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-orange-400 to-yellow-400 text-white text-center py-4">
        <p>© 2025 Digital Library - BPS Kabupaten Jember</p>
    </footer>

    <script>
        const profileMenuButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');

        if (profileMenuButton) {
            profileMenuButton.addEventListener('click', () => {
                profileMenu.classList.toggle('hidden');
            });
            window.addEventListener('click', (e) => {
                if (!profileMenuButton.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
