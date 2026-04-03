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
</head>

<body>

    <!-- Navbar -->
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
    @php
        $sim = session('simulation');
    @endphp

    <section class="min-h-screen bg-blue-50 flex justify-center items-center p-6 mt-20">
        <div
            class="bg-white shadow-lg rounded-2xl border border-blue-200 p-8 w-full max-w-md transition-all duration-500 hover:shadow-2xl animate-fade-in">
            
            <a href="{{ url('/simulasibiaya') }}" class="text-blue-600 hover:underline">Back</a>

            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Hasil Simulasi Biaya
            </h2>

            @if($sim)
                <p class="text-gray-700 mb-4">
                    {{ $sim->result_summary }}
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mb-6 mt-6 text-center">
                    Rp {{ number_format($sim->budget ?? 0, 0, ',', '.') }}
                </h2>
            @else
                <p class="text-center text-gray-500">
                    Data simulasi tidak ditemukan.
                </p>
            @endif

            <!-- Tombol Whatsapp -->
            <div class="pt-4">
                <a href="https://wa.me/6281574508173" target="_blank"
                    class="block w-full text-center bg-primary text-white font-semibold py-2.5 rounded-lg hover:bg-primary-hover focus:ring-2 focus:ring-green-300 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                    Hubungi Via Whatsapp
                </a>
            </div>

        </div>
    </section>

    <!-- Animasi Fade-In -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.8s ease-in-out both; }
    </style>

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
