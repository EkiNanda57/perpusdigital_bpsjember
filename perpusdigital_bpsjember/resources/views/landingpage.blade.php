<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library BPS Kabupaten Jember</title>
    <style>
        html { scroll-behavior: smooth; }
    </style>

    <link rel="icon" type="image/png" href="{{ asset('logo/Logo-Digital.jpg') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-white font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-40">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo/LogoDigital.png') }}" alt="Logo BPS" class="w-14 h-14">
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8 text-orange-500 font-semibold">
                <a href="#" class="hover:text-orange-600">Beranda</a>
                <a href="#publikasi" class="hover:text-orange-600">Publikasi</a>
                <a href="#tentang-kami" class="hover:text-orange-600">Tentang Kami</a>

                @auth
                    @php
                        $user = auth()->user();
                        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                    @endphp
                    <!-- Avatar dropdown -->
                    <div class="relative">
                        <button id="avatar-btn" class="w-10 h-10 rounded-full bg-orange-500 text-white font-bold flex items-center justify-center hover:bg-orange-600">
                            {{ $initials }}
                        </button>

                        <div id="avatar-menu" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-lg py-2 border border-gray-100 z-50">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
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
            <a href="#publikasi" class="block hover:text-orange-600">Publikasi</a>
            <a href="#tentang-kami" class="block hover:text-orange-600">Tentang Kami</a>

            @auth
                <a href="{{ route('profile.show') }}" class="block hover:text-orange-600">Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left hover:text-orange-600">Logout</button>
                </form>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <!-- Hero Section -->
<section class="relative mt-[90px] overflow-hidden">
    <!-- Background image -->
    <div 
        class="absolute inset-0 bg-cover bg-center" 
        style="background-image: url('{{ asset('logo/BpsJemberr.png') }}');">
    </div>

    <!-- Overlay gradasi oranye agar foto agak pudar -->
    <div class="absolute inset-0 bg-gradient-to-r from-orange-500/80 to-yellow-400/70 mix-blend-multiply"></div>

    <!-- Konten hero -->
    <div class="relative z-10 text-white text-center py-24 px-6">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 leading-snug drop-shadow-lg">
                Selamat Datang di Digital Library <br class="hidden sm:block">BPS Kabupaten Jember
            </h1>
            <p class="text-base sm:text-lg mb-8 drop-shadow-md">
                Penyedia publikasi internal segala kebutuhan data
            </p>

            @guest
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/register" class="border border-white px-6 py-2 rounded font-semibold hover:bg-white hover:text-orange-500 transition">
                    Sign In
                </a>
                <a href="/login" class="border border-white px-6 py-2 rounded font-semibold hover:bg-white hover:text-orange-500 transition">
                    Log In
                </a>
            </div>
            @endguest
        </div>
    </div>

    <!-- Lengkungan bawah -->
    <svg id="publikasi" class="absolute bottom-[-2px] left-0 w-full h-24 text-white z-10"
         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="currentColor" 
              d="M0,224L60,208C120,192,240,160,360,165.3C480,171,600,213,720,218.7C840,224,960,192,1080,186.7C1200,181,1320,203,1380,213.3L1440,224L1440,320L0,320Z"></path>
    </svg>
</section>


    <!-- Publikasi -->
    <section class="container mx-auto py-12 px-6 text-center">
        <h2 class="text-2xl sm:text-3xl text-orange-500 font-semibold mb-4">Publikasi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <!-- Card Sosial -->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'sosial']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoSosial.png') }}" alt="Sosial" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">SOSIAL</h3>
                {{-- <p class="text-white text-sm px-4">Mengumpulkan dan Menyajikan data dasar kependudukan sampai wilayah administrasi terkecil</p> --}}
            </a>

            <!-- Card Produksi-->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'produksi']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoProduksi.png') }}" alt="Produksi" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">PRODUKSI</h3>
                {{-- <p class="text-white text-sm px-4">Memberikan gambaran secara aktual mengenai kondisi pertanian di Indonesia</p> --}}
            </a>

            <!-- Card Distribusi -->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'distribusi']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoDistribusi.png') }}" alt="Distribusi" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">DISTRIBUSI</h3>
                {{-- <p class="text-white text-sm px-4">Memberikan gambaran secara aktual mengenai kondisi ekonomi di seluruh lapangan usaha pertanian di Indonesia</p> --}}
            </a>

            <!-- Card Harga -->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'harga']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoHarga.png') }}" alt="Harga" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">HARGA</h3>
                {{-- <p class="text-white text-sm px-4">Memberikan gambaran secara aktual mengenai kondisi ekonomi di seluruh lapangan usaha pertanian di Indonesia</p> --}}
            </a>

            <!-- Card Neraca Wilayah dan Analisis -->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'neraca wilayah dan analisis']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoNeraca.png') }}" alt="Neraca Wilayah dan Analisis" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">NERACA WILAYAH DAN ANALISIS</h3>
                {{-- <p class="text-white text-sm px-4">Memberikan gambaran secara aktual mengenai kondisi ekonomi di seluruh lapangan usaha pertanian di Indonesia</p> --}}
            </a>

            <!-- Card IPDS -->
            <a href="{{ route('publikasi.publikasipengguna', ['kategori' => 'ipds']) }}" 
            class="card rounded-xl bg-gradient-to-br from-orange-300 to-yellow-400 flex flex-col justify-between items-center py-8 h-auto hover:scale-[1.03] transition-transform duration-300 shadow-md">
                <img src="{{ asset('logo/LogoIpds.png') }}" alt="Ipds" class="w-32 h-32 object-contain mb-4">
                <h3 class="text-white font-bold text-xl mb-2">IPDS</h3>
                {{-- <p class="text-white text-sm px-4">Memberikan gambaran secara aktual mengenai kondisi ekonomi di seluruh lapangan usaha pertanian di Indonesia</p> --}}
            </a>
        </div>
    </section>

    <!-- Footer (tidak diubah) -->
     <footer id="tentang-kami" class="mt-auto bg-gradient-to-r from-yellow-400 to-orange-400 text-white">
    <div class="container mx-auto py-8 px-6">
        <!-- Header Footer -->
        <div class="flex items-center mb-8 pb-4 border-b border-white/40">
            <img src="{{ asset('logo/logo-bps.png') }}" alt="Logo BPS" class="h-10 mr-4">
            <span class="text-xl sm:text-2xl font-bold italic">BADAN PUSAT STATISTIK</span>
        </div>

        <!-- Grid Konten -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 text-sm text-center md:text-left">
            <!-- Kolom Alamat -->
            <div class="md:col-span-5">
                <h3 class="font-bold text-lg mb-3">Badan Pusat Statistik Kabupaten Jember</h3>
                <p>Jl. Cendrawasih No.20, Puring, Slawu, Kec. Patrang, Kabupaten Jember</p>
                <p>Jawa Timur 68116, Indonesia</p>
                <p class="pt-3">Telp (0331) 487642</p>
                <p>Mailbox: bps3509@bps.go.id</p>
                <div class="mt-6 flex justify-center md:justify-start">
                    <img src="{{ asset('logo/logo_footer.png') }}" alt="BerAKHLAK Bangga Melayani Bangsa" class="w-64">
                </div>
            </div>

            <!-- Kolom Tengah (Tentang Kami) -->
            <div class="md:col-span-3 flex flex-col items-center md:items-center">
                <h3 class="font-bold text-lg mb-3">Tentang Kami</h3>
                <a href="https://jemberkab.bps.go.id/id" class="block hover:text-gray-300">BPS Kabupaten Jember</a>
                <a href="https://ppid.bps.go.id/?mfd=0000" class="block hover:text-gray-300">PPID</a>
            </div>

            <!-- Kolom Sosial Media -->
            <div class="md:col-span-4 flex flex-col items-center md:items-end">
                <h3 class="font-bold text-lg mb-3">Sosial Media</h3>
                <div class="flex items-center space-x-4 justify-center md:justify-end">
                    <a href="https://www.instagram.com/bpsjember?igsh=b2d1Z2h2ZWl6Ympl" title="Instagram" class="hover:opacity-80">
                        <img src="{{ asset('logo/social.png') }}" alt="Instagram" class="w-10 h-10">
                    </a>
                    <a href="https://www.tiktok.com/@bpsjember?_t=ZS-90YhqYibmtg&_r=1" title="TikTok" class="hover:opacity-80">
                        <img src="{{ asset('logo/tik-tok.png') }}" alt="TikTok" class="w-10 h-10">
                    </a>
                    <a href="https://youtube.com/@bpskabupatenjember?si=SIM_ocnH3-Cet8mY" title="YouTube" class="hover:opacity-80">
                        <img src="{{ asset('logo/youtube.png') }}" alt="YouTube" class="w-10 h-10">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>


    <!-- Script -->
    <script>
        // Mobile Menu
        document.getElementById('menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Avatar Dropdown
        document.addEventListener('DOMContentLoaded', () => {
            const avatarBtn = document.getElementById('avatar-btn');
            const avatarMenu = document.getElementById('avatar-menu');
            if (avatarBtn && avatarMenu) {
                avatarBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    avatarMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!avatarBtn.contains(e.target) && !avatarMenu.contains(e.target)) {
                        avatarMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
