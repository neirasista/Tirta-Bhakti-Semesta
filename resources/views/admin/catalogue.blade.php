<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/catalogue.js'])
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

<body class="min-h-screen flex bg-gray-50">
    <!-- SIDEBAR (tetap di kiri, tidak ikut scroll) -->
    <aside class="w-64 fixed inset-y-0 left-0 bg-primary shadow-md p-4 flex flex-col justify-between">
        <div>
            <img src="/images/logo.jpeg" alt="Logo" class="w-20 h-20 mx-auto mb-6">
            <nav class="space-y-3 text-base">
                <a href="/admin/dashboard" class="flex items-center gap-4 p-3 rounded-xl transition-all duration-300 ease-in-out
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


                <a href="/admin/catalogue" class="flex items-center gap-4 p-3 rounded-xl transition-all duration-300 ease-in-out
                    {{ request()->is('admin/catalogue') 
                        ? 'bg-white text-purple-700 font-semibold shadow-md' 
                        : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">💳</span> Katalog
                </a>

                <a href="/admin/pemesanan" class="flex items-center gap-4 p-3 rounded-xl transition-all duration-300 ease-in-out
                    {{ request()->is('admin/pemesanan') 
                        ? 'bg-white text-purple-700 font-semibold shadow-md' 
                        : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">🕶️</span> Form Pemesanan
                </a>

                <a href="/admin/orderdata" class="flex items-center gap-4 p-3 rounded-xl transition-all duration-300 ease-in-out
                    {{ request()->is('admin/orderdata') 
                        ? 'bg-white text-purple-700 font-semibold shadow-md' 
                        : 'text-white hover:bg-purple-200 hover:text-purple-900' }}">
                    <span class="text-xl">🌐</span> Order Data
                </a>
            </nav>
        </div>
    </aside>

    <!-- KONTEN KANAN -->
    <div class="flex-1 ml-64 flex flex-col h-screen">
        <!-- TOPBAR -->
        <header
            class="sticky top-0 z-50 bg-white flex justify-between items-center px-6 py-3 border-b border-gray-200 shadow-sm">
            <h2 class="text-2xl font-bold text-gray-800">Katalog</h2>

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
                        </li>
                    </ul>
                </div>
            </div>
        </header>



        <main class="flex-1 overflow-y-auto p-6">



            <section>
    <div class="flex flex-wrap gap-3 container mx-auto px-6 py-4 justify-center md:justify-start">

        @foreach ($categories as $c)
            <button onclick="filterByCategory({{ $c->id }})"
                class="category-btn px-6 py-2 rounded-xl border border-gray-300 text-gray-700 bg-white shadow-sm
                       hover:bg-blue-600 hover:text-white hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                {{ $c->categoryName }}
            </button>
        @endforeach

        <!-- Tombol reset filter -->
        <button onclick="resetFilter()"
            class="px-6 py-2 rounded-xl border border-gray-300 text-gray-700 bg-white shadow-sm
                   hover:bg-gray-200 transition-all duration-200">
            Semua
        </button>

    </div>
</section>


            <!-- Tombol Tambah Produk + Grid Produk -->
            <section class="container mx-auto px-6 py-4">
                <!-- Gabungkan tombol tambah & filter area dalam satu baris -->
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <!-- Tombol Tambah Produk -->
                    <button onclick="openAddModal()"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fa-solid fa-plus mr-2"></i>Tambah Produk
                    </button>

                    <!-- Search dan Filter -->
                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <!-- Search box -->
                        <div class="relative w-full md:w-64">
                            <input id="searchInput" type="text" placeholder="Cari produk..."
    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl shadow-sm ...">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m1.1-5.4A7.25 7.25 0 1110.5 3a7.25 7.25 0 017.25 7.25z" />
                            </svg>
                        </div>

                        <!-- Filter button -->
                        <div class="relative">
                            <button onclick="toggleFilter()"
                                class="p-2 rounded-xl border border-gray-300 bg-white hover:bg-blue-50 transition flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707L14 13.707V19a1 1 0 01-1.447.894l-2-1A1 1 0 0110 18v-4.293L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </button>

                            <!-- Filter dropdown -->
                            <div id="filterMenu"
                                class="hidden absolute right-0 mt-3 w-52 bg-white shadow-lg border border-gray-200 rounded-xl p-4 z-20 transition-all">
                                <h4 class="font-semibold text-sm mb-2 text-gray-700">Filter Grade</h4>
                                <select id="gradeFilterSelect"
                                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none text-gray-700">
                                    <option value="">Semua</option>
                                    <option value="gradeA">Grade A</option>
                                    <option value="gradeB">Grade B</option>
                                    <option value="gradeC">Grade C</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Produk -->
                <div id="katalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                </div>


                <!-- Detail Produk -->
                <div id="productDetail"
                    class="hidden md:col-span-1 bg-white p-6 rounded-md shadow flex flex-col items-center justify-center text-center transition-all duration-300">

                    <h3 id="detailName" class="text-lg font-semibold text-gray-800 mb-2"></h3>
                    <p id="detailDesc" class="text-gray-500 mb-4"></p>
                    <button onclick="closeDetail()"
                        class="mt-4 px-4 py-2 bg-blue-600 rounded-lg text-white hover:bg-blue-700">
                        Tutup
                    </button>
                </div>

            </section>








        </main>

        <!-- ==================== MODALS ==================== -->

        <!-- Modal Tambah Produk -->
        <div id="addModal"
            class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm flex justify-center items-center z-50 px-4">
            <div
                class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 border border-gray-300 overflow-y-auto max-h-[90vh]">

                <h2 class="text-lg font-semibold mb-4">Tambah Produk</h2>
                <p id="createResponseMsg" class="text-sm mb-2"></p>
                <form id="catalogForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addCatalog();">

    <div class="grid gap-3">

        <div>
            <label class="block text-sm font-medium">Nama Produk</label>
            <input name="name" type="text"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium">Deskripsi</label>
            <textarea name="description" rows="3"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">

            <div>
                <label class="block text-sm font-medium">Grade</label>
                <select name="grade_id" id="gradeSelect"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
                    @foreach($grades as $g)
                        <option value="{{ $g->id }}">{{ $g->gradeName }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Kategori</label>
                <select name="category_id" id="categorySelect"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->categoryName }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div>
            <label class="block text-sm font-medium">Harga</label>
            <input name="price" type="number"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium">Gambar Produk</label>
            <input name="images[]" type="file" multiple accept="image/*"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-400">
        </div>

    </div>

    <div class="flex justify-end gap-2 mt-5">
        <button type="button" onclick="closeAddModal()"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    </div>

</form>

            </div>
        </div>


        <div id="editModal"
            class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm flex justify-center items-center z-50 px-4">

            <div
                class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 border border-gray-300 overflow-y-auto max-h-[90vh]">

                <h2 class="text-lg font-semibold mb-4">Edit Produk</h2>

<form id="editCatalogForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); updateCatalog();">

    <input type="hidden" id="edit_id">

    <div class="grid gap-3">

        <div>
            <label class="block text-sm font-medium">Nama Produk</label>
            <input id="edit_name" name="name" type="text"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Deskripsi</label>
            <textarea id="edit_description" name="description" rows="3"
                class="w-full p-2 border border-gray-300 rounded"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">

            <div>
                <label class="block text-sm font-medium">Grade</label>
                <select id="edit_grade_id" name="grade_id"
                    class="w-full p-2 border border-gray-300 rounded">
                    @foreach($grades as $g)
                        <option value="{{ $g->id }}">{{ $g->gradeName }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Kategori</label>
                <select id="edit_category_id" name="category_id"
                    class="w-full p-2 border border-gray-300 rounded">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->categoryName }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div>
            <label class="block text-sm font-medium">Harga</label>
            <input id="edit_price" name="price" type="number"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Gambar Lama</label>
            <img id="edit_preview_img"
                class="w-36 h-36 object-cover border border-gray-300 rounded mx-auto mb-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Ganti Gambar</label>
            <input id="edit_images" name="images[]" type="file" accept="image/*" multiple
    class="w-full p-2 border border-gray-300 rounded">


        </div>

    </div>

    <div class="flex justify-end gap-2 mt-5">
        <button type="button" onclick="closeEditModal()"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    </div>

</form>



            </div>

        </div>
    </div>






    <!-- Modal Hapus Produk -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-white/10 backdrop-blur-sm flex justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 text-center">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Hapus Produk</h2>
            <p id="deleteTarget" class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus produk ini?</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button onclick="confirmDelete()"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>




</body>


</html>