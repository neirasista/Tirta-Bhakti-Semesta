<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    <section class="bg-blue-50 min-h-screen py-16 mt-20">
        <div class="container mx-auto px-6 max-w-4xl text-center">
            <div class="max-w-7xl mx-auto text-center mb-12">
                <h2 class="text-4xl font-bold text-blue-900 mb-3">Kontak Kami</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Beberapa hasil proyek terbaik kami dalam mendukung sistem air bersih dan irigasi yang berkelanjutan.
                </p>
            </div>

           <!-- Kartu Kontak -->
<div class="grid sm:grid-cols-3 gap-6 justify-center">
    <!-- Email -->
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center hover:shadow-lg transition">
        <div class="w-20 h-20 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
            <img src="/images/icons/gmail.png" alt="Email Icon" class="w-10 h-10 object-contain">
        </div>
        <p class="font-semibold text-gray-700">Email</p>
        <a href="mailto:tirtabhakti2013@gmail.com"
           class="text-blue-600 text-sm hover:underline">
           tirtabhakti2013@gmail.com
        </a>
    </div>

    <!-- Whatsapp -->
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center hover:shadow-lg transition">
        <div class="w-20 h-20 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
            <img src="/images/icons/wa.png" alt="WhatsApp Icon" class="w-10 h-10 object-contain">
        </div>
        <p class="font-semibold text-gray-700">Whatsapp</p>

        {{-- nomor sudah dibenerin formatnya --}}
        <a href="https://wa.me/6281574508173"
           target="_blank"
           class="text-blue-600 text-sm hover:underline">
           Chat Sekarang
        </a>
    </div>

    <!-- Instagram -->
    <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center hover:shadow-lg transition">
        <div class="w-20 h-20 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
            <img src="/images/icons/instagram.png" alt="Instagram Icon" class="w-10 h-10 object-contain">
        </div>
        <p class="font-semibold text-gray-700">Instagram</p>

        {{-- kalau belum ada akun, jangan arahkan ke akun dummy --}}
        <a href="#"
           class="text-blue-600 text-sm hover:underline cursor-not-allowed">
           Coming Soon
        </a>
    </div>
</div>



            <!-- Map -->
            <div class="mt-16">
                <h3 class="text-3xl font-bold text-blue-900 mb-6">Kunjungi Kami</h3>
                <div class="w-full h-72 rounded-xl overflow-hidden shadow-md">
                    <iframe class="w-full h-full border-0" loading="lazy" allowfullscreen
    src="https://www.google.com/maps?q=Jl.%20MayJen%20HE%20Sukma%20Km%2013%20No%2046%20Cibolang%20Ciawi%20Bogor%20Jawa%20Barat%2016720&output=embed">
</iframe>

                </div>
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