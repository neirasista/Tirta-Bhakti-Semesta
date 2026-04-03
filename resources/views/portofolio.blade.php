<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/user/portofoliouser.js'])

    <title>CV. Tirta Bhakti Semesta - Portofolio</title>
    <link rel="icon" type="image/jpeg" href="/images/logo.jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- SwiperJS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body>
    <!-- Navbar -->
    <header class="bg-blue-900 text-white fixed top-0 w-full z-50 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-8 py-6">
            <div class="flex items-center space-x-2">
                <img src="/images/logo.jpeg" alt="Logo" class="w-10 h-10 rounded-full">
                <span class="font-semibold text-xl tracking-wide">CV. Tirta Bhakti Semesta</span>
            </div>
            <nav>
                <ul class="flex space-x-6 items-center text-lg">
                    <li><a href="/" class="{{ request()->is('/') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">Home</a></li>
                    <li><a href="/katalog" class="{{ request()->is('katalog') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">Katalog</a></li>
                    <li><a href="/simulasibiaya" class="{{ request()->is('simulasibiaya') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">Simulasi Biaya</a></li>
                    <li><a href="/portofolio" class="{{ request()->is('portofolio') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">Portofolio</a></li>
                    <li><a href="/contactus" class="{{ request()->is('contactus') ? 'text-gray-300 underline font-semibold' : 'hover:text-gray-300' }}">Kontak Kami</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Portofolio -->
    <section class="pt-32 pb-20 px-6 md:px-12 lg:px-20 bg-gray-50">
        <div class="max-w-7xl mx-auto text-center mb-12">
            <h2 class="text-4xl font-bold text-blue-900 mb-3">Portofolio Proyek Kami</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Beberapa hasil proyek terbaik kami dalam mendukung sistem air bersih dan irigasi yang berkelanjutan.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10 text-center">

            @forelse ($portfolios as $item)
                <div class="card cursor-pointer"
                    data-title="{{ $item->title }}"
                    data-shortdesc="{{ Str::limit($item->description, 100) }}"
                    data-longdesc="{{ $item->description }}">

                    <!-- Swiper -->
                    <div class="swiper swiper-{{ $item->id }}">
                        <div class="swiper-wrapper">

                            @foreach ($item->images as $img)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-64 object-cover rounded-lg"
                                        alt="{{ $item->title }}">
                                </div>
                            @endforeach

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                    <div class="card-content">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->title }}</h4>
                        <p class="text-sm text-gray-500">{{ Str::limit($item->description, 80) }}</p>
                    </div>
                </div>

            @empty
                <p class="text-center text-gray-500 col-span-3">Belum ada portofolio.</p>
            @endforelse

        </div>
    </section>

    <!-- Modal -->
    <div id="modal"
        class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex justify-center items-center p-4 text-center">
        <div class="bg-white rounded-2xl shadow-xl max-w-5xl w-full p-4 relative flex flex-col overflow-y-auto max-h-screen">

            <!-- Tombol close -->
            <button id="closeModal" class="mb-4 self-end text-blue-900 px-4 py-2 rounded-lg z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Swiper Modal -->
            <div class="swiper modal-swiper relative flex justify-center items-center overflow-visible">
                <div class="swiper-wrapper" id="modalImages"></div>

                <div class="swiper-button-next bg-blue-900/70 hover:bg-blue-900 text-white rounded-xl p-3 shadow-lg"></div>
                <div class="swiper-button-prev bg-blue-900/70 hover:bg-blue-900 text-white rounded-xl p-3 shadow-lg"></div>
                <div class="swiper-pagination mt-2"></div>
            </div>

            <h3 id="modalTitle" class="text-2xl font-bold text-blue-900 mt-4 mb-2"></h3>
            <p id="modalDesc" class="text-gray-700 leading-relaxed"></p>
        </div>
    </div>

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