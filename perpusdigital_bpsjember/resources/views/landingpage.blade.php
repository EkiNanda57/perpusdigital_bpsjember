<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library - BPS Kabupaten Jember</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo/logose.png') }}" alt="Logo BPS" class="w-14 h-14">
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8 text-orange-500 font-semibold">
                <a href="#" class="hover:text-orange-600">Beranda</a>
                <a href="#" class="hover:text-orange-600">Publikasi</a>
                <a href="#" class="hover:text-orange-600">Tentang Kami</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden focus:outline-none">
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden bg-white px-6 pb-4 space-y-3 text-orange-500 font-semibold">
            <a href="#" class="block hover:text-orange-600">Beranda</a>
            <a href="#" class="block hover:text-orange-600">Publikasi</a>
            <a href="#" class="block hover:text-orange-600">Tentang Kami</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-orange-400 to-yellow-400 text-white text-center py-16 px-6">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 leading-snug">
                Selamat Datang di Digital Library <br class="hidden sm:block">BPS Kabupaten Jember
            </h1>
            <p class="text-base sm:text-lg mb-8">
                Penyedia publikasi internal segala kebutuhan data
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/login" class="border border-white px-6 py-2 rounded font-semibold hover:bg-white hover:text-orange-500 transition">
                    Sign In
                </a>
                <a href="/register" class="border border-white px-6 py-2 rounded font-semibold hover:bg-white hover:text-orange-500 transition">
                    Log In
                </a>
            </div>
        </div>
    </section>

    <section class="container mx-auto py-10 px-6 text-center">
    <!-- Judul di atas card -->
    <h2 class="text-2xl sm:text-3xl text-orange-500 font-semibold mb-4">
        Publikasi
    </h2>

    <!-- Category Cards -->
    <section class="container mx-auto py-12 px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-center">
    <!-- Card Penduduk -->
    <div class="rounded-xl bg-gradient-to-r from-[#01A2E9] to-[#2473BA] flex flex-col justify-between items-center py-8 h-56 hover:scale-[1.03] transition-transform duration-300 shadow-md">
        <img src="{{ asset('logo/Sensus Penduduk.png') }}" alt="Penduduk"
             class="w-40 h-40 object-contain mb-4">
        <h3 class="text-white font-bold text-xl mb-2">Penduduk</h3>
    </div>

    <!-- Card Pertanian -->
    <div class="rounded-xl bg-gradient-to-r from-[#2AB930] to-[#88C64A] flex flex-col justify-between items-center py-8 h-56 hover:scale-[1.03] transition-transform duration-300 shadow-md">
        <img src="{{ asset('logo/Sensus Pertanian.png') }}" alt="Pertanian"
             class="w-40 h-40 object-contain mb-4">
        <h3 class="text-white font-bold text-xl mb-2">Pertanian</h3>
    </div>

    <!-- Card Ekonomi -->
    <div class="rounded-xl bg-gradient-to-r from-[#F7931E] to-[#FDC830] flex flex-col justify-between items-center py-8 h-56 hover:scale-[1.03] transition-transform duration-300 shadow-md">
        <img src="{{ asset('logo/Sensus Ekonomi.png') }}" alt="Ekonomi"
             class="w-40 h-40 object-contain mb-4">
        <h3 class="text-white font-bold text-xl mb-2">Ekonomi</h3>
    </div>
</section>



</section>



    <!-- Footer -->
    <footer class="mt-auto bg-gradient-to-r from-orange-400 to-yellow-400 text-white text-center py-4">
        <p>2025 Digital Library - BPS Kabupaten Jember</p>
    </footer>

    <!-- Script for Mobile Menu -->
    <script>
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
