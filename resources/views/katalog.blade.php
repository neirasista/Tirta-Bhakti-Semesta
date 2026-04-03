<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/user/katalog.js'])

    <title>CV. Tirta Bhakti Semesta</title>
    <link rel="icon" type="image/jpeg" href="/images/logo.jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


</head>


<body>

    <!-- Navbar -->
    <header class="bg-blue-900 text-white fixed top-0 w-full z-50 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-8 py-6">
            <div class="flex items-center space-x-2">
                <img src="images/logo.jpeg" alt="Logo" class="w-10 h-10 rounded-full">
                <span class="font-semibold text-xl tracking-wide">CV. Tirta Bhakti Semesta</span>
            </div>
            <nav>
                <ul class="flex space-x-6 items-center text-lg">
                    <li>
                        <a href="/"
                            class="{{ request()->is('/') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="katalog"
                            class="{{ request()->is('katalog') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">
                            Katalog
                        </a>
                    </li>
                    <li>
                        <a href="simulasibiaya"
                            class="{{ request()->is('simulasibiaya') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">
                            Simulasi Biaya
                        </a>
                    </li>
                    <li>
                        <a href="portofolio"
                            class="{{ request()->is('portofolio') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">
                            Portofolio
                        </a>
                    </li>
                    <li>
                        <a href="contactus"
                            class="{{ request()->is('contactus') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">
                            Kontak Kami
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Katalog Produk -->

    <!-- Kategori produk dinamis -->
    <section>
        <div id="categoryButtons"
            class="flex flex-wrap gap-3 container mx-auto mt-25 px-6 py-4 justify-center md:justify-start">
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold mb-6 text-primary">Katalog</h2>

        <!-- Wrapper search + filter -->
        <div class="flex items-center justify-between my-6 flex-wrap gap-3">

            <!-- Search -->
            <div class="relative w-full md:w-2/3">
                <input type="text" id="searchInput" placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m1.1-5.4A7.25 7.25 0 1110.5 3a7.25 7.25 0 017.25 7.25z" />
                </svg>
            </div>

            <!-- Filter -->
            <div class="relative">
                <button onclick="toggleFilter()"
                    class="p-2 rounded-xl border border-gray-300 bg-white hover:bg-blue-50 transition flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707L14 13.707V19a1 1 0 01-1.447.894l-2-1A1 1 0 0110 18v-4.293L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>

                <div id="filterMenu"
                    class="hidden absolute right-0 mt-3 w-52 bg-white shadow-lg border border-gray-200 rounded-xl p-4 z-20 transition-all">
                    <h4 class="font-semibold text-sm mb-2 text-gray-700">Filter Grade</h4>
                    <select id="gradeFilter"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none text-gray-700">
                    </select>
                </div>
            </div>
        </div>

        <!-- Wrapper GRID + DETAIL -->
        <div class="flex gap-6 transition-all duration-300">

            <!-- GRID PRODUK -->
            <div id="produkContainer" class="w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center" id="productGrid"></div>
            </div>

            <!-- DETAIL PRODUK -->
<!-- DETAIL PRODUK -->
<div id="productDetail"
  class="hidden md:w-1/3 bg-white p-6 rounded-md shadow flex flex-col items-center text-center transition-all duration-300">

  <div class="w-full h-56 mb-4 flex items-center justify-center overflow-hidden rounded-lg border">
    <img id="detailImage" src="/images/noimage.png"
      class="object-contain w-full h-full" alt="detail">
  </div>

  <h3 id="detailName" class="text-lg font-semibold text-gray-800 mb-2"></h3>
  <p id="detailDesc" class="text-gray-500 mb-4"></p>

  <button onclick="closeDetail()"
    class="mt-4 px-4 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-700">
    Tutup
  </button>
</div>



        </div>




    </section>



    





    <!--- Footer --->
    <section class="bg-blue-900 text-white">
        <div class="container mx-auto px-6 py-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Kolom 1: Logo / Deskripsi -->
            <div>
                <h2 class="text-2xl font-bold mb-4">CV Tirta Bhakti Semesta</h2>
                <img src="images/logo.jpeg" alt="logo" class="w-10 h-10">
                <p class="text-sm text-gray-300 py-6">
                    Platform informasi instalasi pembuangan air limbah CV. Tirta Bhakti Semesta
                </p>
            </div>

            <!-- Kolom 2: Navigasi -->
            <ul class="space-y-2 text-gray-300">
    <li><a href="{{ url('/') }}" class="hover:text-white">Home</a></li>
    <li><a href="{{ url('/katalog') }}" class="hover:text-white">Katalog</a></li>
    <li><a href="{{ url('/simulasibiaya') }}" class="hover:text-white">Simulasi</a></li>
    <li><a href="{{ url('/portofolio') }}" class="hover:text-white">Portofolio</a></li>
    <li><a href="{{ url('/contactus') }}" class="hover:text-white">Kontak Kami</a></li>
</ul>


            <!-- Kolom 3: Kontak -->
            <div>
                <h3 class="font-semibold mb-4">Kontak</h3>
                <p>Email:
    <p>Email:
    <a href="mailto:tirtabhakti2013@gmail.com?subject=Konsultasi%20CV%20Tirta%20Bhakti%20Semesta"
       class="text-green-300 hover:text-white">
       tirtabhakti2013@gmail.com
    </a>
</p>

</p>
<p>Whatsapp:
    <a href="https://wa.me/6281574508173"
       target="_blank"
       class="text-green-300 hover:text-white">
       +62 815-7450-8173
    </a>
</p>
<p>Alamat: Jl. MayJen HE Sukma Km 13 No 46 Cibolang, Ciawi, Bogor</p>

            </div>
        </div>

        <div class="text-center mt-10 text-gray-400 text-sm">
            &copy; 2025 CV Tirta Bhakti Semesta. All rights reserved.
        </div>

    </section>





</body>

</html>