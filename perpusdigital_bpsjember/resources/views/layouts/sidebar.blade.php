<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex relative">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-gradient-to-b from-orange-400 to-yellow-300 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full
               md:relative md:translate-x-0 transition duration-200 ease-in-out shadow-lg z-50">

        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 px-4">
            <img src="{{ asset('logo/logose.png') }}" alt="Logo Perpustakaan" class="w-10 h-10 object-contain">
            <span class="text-2xl font-bold tracking-wide">Perpustakaan</span>
        </a>

        <!-- Menu Sidebar -->
        <nav class="mt-10 flex flex-col space-y-2">
            @php
                $user = auth()->user();
                $role = $user && $user->roles->isNotEmpty()
                    ? $user->roles->first()->role_name
                    : 'pengguna';
            @endphp

            {{-- Dashboard sesuai Role --}}
            @if (strtolower($role) === 'admin')
                <a href="{{ route('dashboard-user.admin-dashboard') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Dashboard</a>
                <a href="{{ route('kategori.kategori') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Kategori</a>
                <a href="#"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Publikasi</a>

            @elseif (strtolower($role) === 'operator')
                <a href="{{ route('dashboard-user.operator-dashboard') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Dashboard</a>
                <a href="#"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Kelola Publikasi</a>

            @else {{-- pengguna biasa --}}
                <a href="{{ route('dashboard-user.pengguna-dashboard') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Dashboard</a>
                {{-- <a href="{{ route('kategori.kategori') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Kategori</a> --}}
                <a href="{{ route('publikasi.publikasi') }}"
                   class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Publikasi</a>
            @endif
        </nav>
    </aside>

    <div id="overlay" class="fixed inset-0 hidden z-40 md:hidden"></div>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow py-4 px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="md:hidden bg-orange-500 text-white p-2 rounded-md focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-xl font-semibold text-orange-500">@yield('title')</h2>
            </div>

            {{-- Info User --}}
            <div class="flex items-center gap-4">
                @auth
                    <span class="hidden sm:block text-gray-700 font-medium">
                        Halo, {{ auth()->user()->name }} ({{ ucfirst($role) }})
                    </span>
                @endauth

                <div class="relative">
                    <button id="profile-menu-button"
                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-500
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400">
                        <span class="font-bold text-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </button>

                    <div id="profile-menu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1
                                ring-1 ring-black ring-opacity-5 z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Isi Konten -->
        <main class="flex-grow bg-gray-100 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-auto bg-gradient-to-r from-orange-400 to-yellow-400 text-white text-center py-4">
            <p>© 2025 Digital Library - BPS Kabupaten Jember</p>
        </footer>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Dropdown Profil
        const profileMenuButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');

            // Tampilkan/sembunyikan menu saat tombol diklik
            profileMenuButton.addEventListener('click', () => {
                profileMenu.classList.toggle('hidden');
            });

            // Sembunyikan menu jika mengklik di luar area dropdown
            window.addEventListener('click', (event) => {
                if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
    </script>

</body>
</html>
