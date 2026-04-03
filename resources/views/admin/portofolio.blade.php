<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/portofolio.js'])
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

<body class="min-h-screen">

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
    <div class="flex-1 flex flex-col h-screen ml-64">

        <!-- TOPBAR -->
        <header
            class="sticky top-0 z-50 bg-white flex justify-between items-center px-6 py-3 border-b border-gray-200 shadow-sm">
            <h2 class="text-2xl font-bold text-gray-800">Portofolio</h2>

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



        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">

         <h2 class="text-2xl font-bold mb-3">Preview</h2>

<section class="py-16 ">
    <div class="container mx-auto px-6">

        <!-- GRID YANG BENAR -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach ($portfolios as $item)
                <div class="bg-gray-100 rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6 text-center">

                    <div class="overflow-hidden relative rounded-2xl mb-4">
                        <img src="{{ asset('storage/' . $item->images[0]) }}"
                             class="object-cover w-full h-64 rounded-2xl">

                        <div class="absolute top-3 right-3 flex gap-2">
                            <button class="btn-edit bg-white/80 hover:bg-blue-100 text-blue-600 p-2 rounded-full shadow transition"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}"
                                    data-desc="{{ $item->description }}"
                                    data-images="{{ json_encode($item->images) }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.portofolio.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus portfolio ini?');">
                                @csrf
                                @method('DELETE')

                                <button class="bg-white/80 hover:bg-red-100 text-red-600 p-2 rounded-full shadow transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="font-semibold text-xl mb-2">{{ $item->title }}</h4>

                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($item->description, 80) }}
                    </p>

                    <a href="{{ route('admin.portofolio.show', $item->id) }}"
   onclick="event.stopPropagation();"
   class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition inline-block">
   Lihat
</a>


                </div>
            @endforeach

        </div>

    </div>
</section>


            <h2 class="text-2xl font-bold mb-3">List Portofolio</h2>

            <div class="flex items-center justify-end mb-3">
                <button class="bg-primary text-white px-3 py-1 rounded-md" id="openModal">+</button>
            </div>

            <!-- === LIST PORTOFOLIO DINAMIS === -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold text-center text-blue-900 mb-12">Portofolio</h3>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse ($portfolios as $item)
                <div class="bg-gray-100 rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 p-6 text-center">

                    <div class="overflow-hidden relative rounded-2xl mb-4">
                        <img src="{{ asset('storage/' . $item->images[0]) }}"
                             class="object-cover w-full h-64 rounded-2xl">

                        <!-- Tombol Edit & Hapus -->
                        <div class="absolute top-3 right-3 flex gap-2">
                            <button class="btn-edit bg-white/80 hover:bg-blue-100 text-blue-600 p-2 rounded-full shadow transition"
                                    data-id="{{ $item->id }}"
                                    data-title="{{ $item->title }}"
                                    data-desc="{{ $item->description }}"
                                    data-images="{{ json_encode($item->images) }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.portofolio.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus portfolio ini?');">
                                @csrf
                                @method('DELETE')

                                <button class="bg-white/80 hover:bg-red-100 text-red-600 p-2 rounded-full shadow transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h4 class="font-semibold text-xl mb-2">{{ $item->title }}</h4>

                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($item->description, 80) }}
                    </p>

                    <a href="{{ route('admin.portofolio.show', $item->id) }}"
   class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition inline-block">
   Lihat
</a>


                </div>
            @empty
                <p class="text-gray-500 text-center col-span-3">Belum ada portofolio.</p>
            @endforelse

        </div>
    </div>
</section>




            <!-- === MODAL TAMBAH === -->
            <div id="modal"
                class="hidden fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-[9999]">
                <div class="bg-white p-6 rounded-xl shadow-lg w-96">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Tambah Portofolio</h2>
                    <form action="{{ route('admin.portofolio.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Portofolio</label>
        <input type="text" name="title"
               class="w-full border border-gray-300 rounded-md p-2"
               required>
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
        <textarea name="description"
                  class="w-full border border-gray-300 rounded-md p-2"
                  required></textarea>
    </div>

    <div class="mb-3">
        <label class="block text-gray-700 font-semibold mb-2 text-lg">Gambar</label>
        <input type="file" name="images[]" accept="image/*" multiple
               class="block w-full text-gray-800 text-base 
               file:py-2 file:px-4 file:bg-blue-100 file:text-blue-700" required>
    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button type="button" id="closeModal"
                class="px-3 py-1 rounded-md bg-gray-300">Batal</button>
        <button type="submit"
                class="px-3 py-1 rounded-md bg-primary text-white">Simpan</button>
    </div>
</form>

                </div>
            </div>

            <!-- === MODAL EDIT === -->
            <div id="editModal"
                class="hidden fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-[9999]">
                <div class="bg-white p-6 rounded-xl shadow-lg w-96">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Edit Portofolio</h2>
                    <form id="editForm" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Pekerjaan</label>
        <input id="editTitle" name="title" type="text"
               class="w-full border border-gray-300 rounded-md p-2">
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
        <textarea id="editDesc" name="description"
                  class="w-full border border-gray-300 rounded-md p-2"></textarea>
    </div>

    <div>
        <label class="block text-gray-700 font-semibold mb-2 text-lg">Gambar Baru</label>
        <input id="editGambar" type="file" name="images[]" accept="image/*" multiple
               class="block w-full text-gray-800 text-base file:bg-blue-100" />

        <!-- PREVIEW GAMBAR LAMA -->
        <div class="mt-3">
            <img id="editPreview" src="" 
                class="w-full h-40 object-cover rounded-md border border-gray-300 hidden" />
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button type="button" id="closeEditModal"
                class="px-3 py-1 rounded-md bg-gray-300">Batal</button>
        <button type="submit"
                class="px-3 py-1 rounded-md bg-primary text-white">Simpan Perubahan</button>
    </div>
</form>

                </div>
            </div>

            <!-- === MODAL DELETE === -->
            <div id="deleteModal"
                class="hidden fixed inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center z-[9999]">
                <div class="bg-white p-6 rounded-xl shadow-lg w-80 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Hapus Portofolio?</h2>
                    <p id="deleteTarget" class="text-gray-600 text-sm mb-4"></p>
                    <div class="flex justify-center gap-3">
                        <button type="button" id="cancelDelete"
                            class="px-4 py-1.5 rounded-md bg-gray-300 hover:bg-gray-400 transition">Batal</button>
                        <button type="button"
                            class="px-4 py-1.5 rounded-md bg-red-600 text-white hover:bg-red-700 transition">Hapus</button>
                    </div>
                </div>
            </div>


        </main>



</body>


</html>