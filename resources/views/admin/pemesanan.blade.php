<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/pemesanan.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <title>CV. Tirta Bhakti Semesta</title>
    <link rel="icon" type="image/jpeg" href="/images/logo.jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">



    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


</head>

<body class="flex min-h-screen bg-gray-50">

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-screen w-64 bg-primary shadow-md p-4 flex flex-col justify-between">
        <div>

            <img src="/images/logo.jpeg" alt="Logo" class="w-20 h-20 mx-auto mb-6">
            <nav class="space-y-3 text-base">
                <!-- text-base = sedikit lebih besar -->
                <a href="/admin/dashboard" class="flex items-center gap-4 p-3 rounded-xl 
        transition-all duration-300 ease-in-out
        {{ request()->is('admin/dashboard') 
            ? 'bg-white text-purple-700 font-semibold shadow-md' 
            : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">🏠</span> Dashboard
                </a>

               <a href="/admin/portofolio"
   class="flex items-center gap-4 p-3 rounded-xl transition-all duration-300 ease-in-out
   {{ request()->is('admin/portofolio*')
        ? 'bg-white text-purple-700 font-semibold shadow-md'
        : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
    <span class="text-xl">🖼️</span> Portofolio
</a>


                <a href="/admin/catalogue" class="flex items-center gap-4 p-3 rounded-xl 
        transition-all duration-300 ease-in-out
        {{ request()->is('admin/catalogue') 
            ? 'bg-white text-purple-700 font-semibold shadow-md' 
            : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">💳</span> Katalog
                </a>

                <a href="/admin/pemesanan" class="flex items-center gap-4 p-3 rounded-xl 
        transition-all duration-300 ease-in-out
        {{ request()->is('admin/pemesanan') 
            ? 'bg-white text-purple-700 font-semibold shadow-md' 
            : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">🕶️</span> Form Pemesanan
                </a>

                <a href="/admin/orderdata" class="flex items-center gap-4 p-3 rounded-xl 
        transition-all duration-300 ease-in-out
        {{ request()->is('admin/orderdata') 
            ? 'bg-white text-purple-700 font-semibold shadow-md' 
            : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">🌐</span> Order Data
                </a>
            </nav>

        </div>
    </aside>

    <!-- Kontainer utama (Topbar + Konten) -->
    <div class="flex-1 ml-64 flex flex-col h-screen">

        <!-- TOPBAR -->
        <header
            class="sticky top-0 z-50 bg-white flex justify-between items-center px-6 py-3 border-b border-gray-200 shadow-sm">
            <h2 class="text-2xl font-bold text-gray-800">Form Pemesanan</h2>

            <div class="relative">
                <!-- Tombol Profil -->
                <div id="profileButton"
                    class="flex items-center gap-3 cursor-pointer select-none p-2 rounded-lg hover:bg-gray-100 transition">
                    <img src="https://ui-avatars.com/api/?name=John+Doe" alt="Profile"
                        class="w-10 h-10 rounded-full border border-gray-300">
                    <div class="hidden sm:block">
                        <p class="text-sm font-semibold text-gray-700">John Doe</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>

                <!-- Dropdown -->
                <div id="profileMenu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                    <ul class="text-sm text-gray-700">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit"
        class="w-full text-left px-4 py-2 hover:bg-gray-100 transition duration-150">
        Logout
    </button>
</form>

                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main scrollable content -->
        <!-- Main scrollable content -->
<main class="flex-1 overflow-y-auto p-6">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" 
            x-transition 
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
            <button @click="show = false" class="ml-4 text-sm font-bold">×</button>
        </div>
    @endif
    <section class="flex justify-center items-start py-8">
        <div
            class="bg-white shadow-lg rounded-2xl border border-blue-200 p-8 w-full max-w-xl transition-all duration-500 hover:shadow-2xl">
            <!-- form kamu di sini -->

                    <form method="POST" action="{{ route('admin.pemesanan.store') }}" class="space-y-6">
    @csrf

    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">Nama Pemesan</label>
        <input type="text" name="nama" placeholder="Nama Pemesan"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-300 text-base"
            required />
    </div>

    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">Luas Area (m³)</label>
        <input type="text" name="luasarea" placeholder="Contoh : 150m³"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-300 text-base"
            required />
    </div>

    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">No Telepon</label>
        <input type="number" name="notelp" placeholder="No Telepon"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-300 text-base"
            required />
    </div>

    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">Tanggal Order</label>
        <input type="date" name="tanggal_order"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-300 text-base"
            required />
    </div>

    <!-- GRADE -->
    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">Grade</label>
        <select name="grade_id" id="addGrade"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->gradeName }}</option>
            @endforeach
        </select>
    </div>

    <!-- TIPE BAK -->
<div>
    <label class="block text-gray-700 font-semibold mb-2 text-base">Tipe Bak</label>
    <select name="tank_type"
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        <option value="tanam">Bak Tanam</option>
        <option value="fiber">Bak Fiber</option>
    </select>
</div>


    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-base">Catatan (Opsional)</label>
        <input type="text" name="catatan" placeholder="Masukkan Catatan"
            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-300 text-base" />
    </div>

    <div class="pt-4">
        <button type="submit"
            class="w-full bg-primary text-white font-semibold py-3 text-base rounded-lg hover:bg-primary-hover focus:ring-2 focus:ring-green-300 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
            Simpan
        </button>
    </div>
</form>

                </div>
            </section>

        </main>

    </div>
</body>



</html>