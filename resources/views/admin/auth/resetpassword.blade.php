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

<body class="bg-gray-100 min-h-screen flex overflow-hidden">

    <!-- Bagian kiri: background biru diagonal -->
    <div class="w-1/2 relative flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-primary clip-main"></div>
        <img src="{{ asset('images/logo.jpeg') }}" class="w-56 h-56 z-10" alt="Logo">
    </div>

    <!-- Bagian kanan: form login -->
    <div class="flex items-center justify-center w-1/2 bg-gray-100 p-16">
        <div class="w-full max-w-md p-10 bg-blue-100 rounded-lg shadow-lg">
            <div class="mb-4 text-left">
                <a href="#" class="text-sm text-blue-600 hover:underline">Back</a>
            </div>
            <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center">Reset Password</h2>

            <form method="POST" action="#">
                @csrf
                <div class="mb-6">
                    <label class="block mb-1 text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" placeholder="Masukkan email anda"
                        class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold hover:bg-primary-hover transition duration-200">
                    Reset
                </button>
            </form>
        </div>
    </div>

    <style>
    /* Efek diagonal penuh sampai batas kanan */
    .clip-diagonal {
        clip-path: polygon(0 0, 105% 0, 85% 100%, 0% 100%);
    }

    .clip-main {
        clip-path: polygon(0 0, 105% 0, 95% 100%, 0% 100%);
    }


    html,
    body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    </style>
</body>




</html>