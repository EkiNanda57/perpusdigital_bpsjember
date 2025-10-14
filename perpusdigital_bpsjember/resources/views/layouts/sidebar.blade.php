<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex relative">

    <!-- sidebar -->
    <aside id="sidebar"
        class="bg-gradient-to-b from-orange-400 to-yellow-300 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full
               md:relative md:translate-x-0 transition duration-200 ease-in-out shadow-lg z-50">

        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 px-4">
            <img src="{{ asset('logo/logose.png') }}" alt="Logo Perpustakaan" class="w-10 h-10 object-contain">
            <span class="text-2xl font-bold tracking-wide">Perpustakaan</span>
        </a>

        <!-- Menu -->
        <nav class="mt-10 flex flex-col space-y-2">
            <a href="#" class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Dashboard</a>
            <a href="{{ route('kategori.kategori') }}" class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Kategori</a>
            <a href="#" class="font-semibold hover:bg-orange-500 px-4 py-2 rounded-md transition">Publikasi</a>
        </nav>
    </aside>


    <div id="overlay" class="fixed inset-0 hidden z-40 md:hidden"></div>

    {{-- konten utama --}}
    <div class="flex-1 flex flex-col min-h-screen">

        <!-- HEADER -->
        <header class="bg-white shadow py-4 px-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <!-- Tombol Burger -->
                <button id="sidebar-toggle" class="md:hidden bg-orange-500 text-white p-2 rounded-md focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h2 class="text-xl font-semibold text-orange-500">@yield('title', 'Dashboard')</h2>
            </div>

            <div>
                <span class="text-gray-700 font-medium">
                @php
                        $role = auth()->user()->roles->first()->role_name;
                @endphp
                    Halo, {{ auth()->user()->name }} ({{ $role }})
                </span>
            </div>

        </header>

        <!-- konten -->
        <main class="flex-grow bg-gray-100 p-6">
            @yield('content')
        </main>

        <!-- footer -->
        <footer class="mt-auto bg-gradient-to-r from-orange-400 to-yellow-400 text-white text-center py-4">
            <p>2025 Digital Library - BPS Kabupaten Jember</p>
        </footer>
    </div>

    <!-- script toggle -->
    <script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('sidebar-toggle');

    function toggleSidebar() {
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>


</body>
</html>
