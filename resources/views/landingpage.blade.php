<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CDN -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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

    <div>
        <div class="relative w-full overflow-hidden rounded-lg shadow-lg pt-20">
            <!-- Slides wrapper -->
            <div id="slider" class="flex transition-transform duration-500">
                <!-- Overlay teks + CTA -->
                <div
                    class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white p-6">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4">Selamat Datang!</h2>
                    <p class="mb-6 text-lg md:text-xl">Temukan produk terbaik kami di sini.</p>
                    <a href="katalog" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold">
                        Lihat Katalog
                    </a>
                </div>
                <img src="https://picsum.photos/id/1015/800/400" class="w-full flex-shrink-0" alt="Slide 1">
                <img src="https://picsum.photos/id/1016/800/400" class="w-full flex-shrink-0" alt="Slide 2">
                <img src="https://picsum.photos/id/1018/800/400" class="w-full flex-shrink-0" alt="Slide 3">
                <img src="https://picsum.photos/id/1020/800/400" class="w-full flex-shrink-0" alt="Slide 4">
            </div>

            <!-- Left arrow -->
            <div id="prev"
                class="swiper-button-prev bg-blue-900/70 hover:bg-blue-900 text-white rounded-xl p-3 top-1/2 transform -translate-y-1/2 left-2 z-50 shadow-lg cursor-pointer">
                &#10094;
            </div>

            <!-- Right arrow -->
            <div id="next"
                class="swiper-button-next bg-blue-900/70 hover:bg-blue-900 text-white rounded-xl p-3 top-1/2 transform -translate-y-1/2 right-2 z-50 shadow-lg cursor-pointer">
                &#10095;
            </div>

        </div>

        <script>
        const slider = document.getElementById("slider");
        const prev = document.getElementById("prev");
        const next = document.getElementById("next");

        let currentIndex = 0;
        const slides = slider.children;
        const totalSlides = slides.length;

        function updateSlide() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        next.addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlide();
        });

        prev.addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlide();
        });
        </script>

    </div>
    <!-- About Content -->
    <section class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <img src="https://picsum.photos/id/1005/600/400" alt="Company"
                class="rounded-lg shadow-lg w-full object-cover">

            <div>
                <h3 class="text-2xl font-bold text-blue-900 mb-4">Who We Are</h3>
                <p class="mb-4">
                    CV. Tirta Bhakti Semesta adalah perusahaan yang bergerak di bidang jasa pembuatan instalasi
                    pembuangan air limbah.
                    Kami berdedikasi untuk memberikan produk dan layanan terbaik kepada pelanggan.
                </p>
                <p class="mb-4">
                    Dengan pengalaman bertahun-tahun, kami selalu mengedepankan inovasi, kualitas, dan kepuasan
                    pelanggan.
                </p>
                <a href="/contact"
                    class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!--Layanan Kami-->

    <section class="bg-gray-100 py-10">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center text-blue-900 mb-8">Layanan Kami</h3>
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Murah">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Harga Terjangkau</h4>
                    <p class="text-gray-600">Kami memberikan layanan berkualitas tinggi dengan harga hanya 1k
                        untuk
                        semua pelanggan.</p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Cepat">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Proses Cepat</h4>
                    <p class="text-gray-600">Kami bisa menyelesaikan pekerjaan dalam waktu singkat tanpa
                        mengurangi
                        kualitas.</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Rapi">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Kualitas Terjamin</h4>
                    <p class="text-gray-600">Setiap hasil kerja kami selalu rapi, detail, dan memuaskan
                        pelanggan.
                    </p>
                </div>

            </div>
        </div>
    </section>



    <!-- Portofolio -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold text-center text-blue-900 mb-12">Portofolio</h3>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse ($portfolios as $item)
                <div class="bg-gray-100 rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6 text-center">

                    <div class="w-full flex items-center justify-center mb-4">
                        <div class="overflow-hidden rounded-2xl w-full h-56 bg-gray-50 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $item->images[0]) }}"
                                 alt="{{ $item->title }}"
                                 class="object-cover w-full h-full rounded-2xl">
                        </div>
                    </div>

                    <h4 class="font-semibold text-xl mb-2">{{ $item->title }}</h4>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($item->description, 80) }}
                    </p>

                    <a href="/portofolio"
                       class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                       Lihat Detail
                    </a>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Belum ada portofolio.</p>
            @endforelse

        </div>
    </div>
</section>



    <!-- Mengapa Memilih Kami -->
    <section class="bg-gray-100 py-20">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-center text-blue-900 mb-12">Mengapa Memilih Kami</h3>

            <div class="grid md:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Murah">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Harga Terjangkau</h4>
                    <p class="text-gray-600">Kami memberikan layanan berkualitas tinggi dengan harga hanya 1k untuk
                        semua pelanggan.</p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Cepat">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Proses Cepat</h4>
                    <p class="text-gray-600">Kami bisa menyelesaikan pekerjaan dalam waktu singkat tanpa mengurangi
                        kualitas.</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white p-8 rounded-2xl shadow-md text-center transform transition duration-300 hover:-translate-y-3 hover:shadow-xl hover:bg-blue-50">
                    <div
                        class="bg-blue-100 w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-5 transition-transform duration-300 hover:scale-110">
                        <img src="images/logo.jpeg" class="w-8 h-8" alt="Rapi">
                    </div>
                    <h4 class="font-semibold text-xl mb-3 text-gray-800">Kualitas Terjamin</h4>
                    <p class="text-gray-600">Setiap hasil kerja kami selalu rapi, detail, dan memuaskan pelanggan.</p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold mb-6 text-blue-900">Lokasi Kami</h3>
        <p class="text-gray-600 mb-8">
            Temukan kami di peta berikut dan dapatkan petunjuk arah langsung.
        </p>

        <div class="rounded-2xl shadow-lg overflow-hidden max-w-4xl mx-auto">
            <iframe
                src="https://www.google.com/maps?q=Jl.%20MayJen%20HE%20Sukma%20Km%2013%20No%2046%20Cibolang%20Rt.03/08%20Telukpinang%20Ciawi%20Bogor%20Jawa%20Barat%2016720&output=embed"
                class="w-full h-[450px] border-0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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