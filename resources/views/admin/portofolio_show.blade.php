<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
    <title>Detail Portofolio - Admin</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto pt-20 pb-10 px-6">
        
        <!-- Back Button -->
        <a href="{{ route('admin.portofolio') }}"
           class="inline-block mb-6 bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            ←
        </a>

        <!-- Title -->
        <h1 class="text-3xl font-bold text-blue-900 mb-4">
            {{ $item->title }}
        </h1>

        <!-- Swiper -->
        <div class="swiper mySwiper rounded-2xl shadow-lg mb-6">
            <div class="swiper-wrapper">
                @foreach ($item->images as $img)
                    <div class="swiper-slide flex justify-center">
                        <img src="{{ asset('storage/'.$img) }}"
                             class="max-h-[450px] w-auto object-contain rounded-xl">
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <!-- Description -->
        <p class="text-gray-700 text-lg leading-relaxed">
            {{ $item->description }}
        </p>

    </div>

    <script>
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: { delay: 3500, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });
    </script>

</body>
</html>
