<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/orderdata.js'])
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
            <h2 class="text-2xl font-bold text-gray-800">Data Pemesanan</h2>

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


        <!-- ======================== -->
        <!-- CONTENT -->
        <!-- ======================== -->
        <div class="p-6">

            <div class="flex justify-end mb-3">
                <button id="openModal"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    + Tambah Data
                </button>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nama Pemesan</th>
                            <th class="px-6 py-3 text-left">Luas Area</th>
                            <th class="px-6 py-3 text-left">No Telepon</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Tipe Bak</th>
                            <th class="px-6 py-3 text-left">Grade</th>
                            <th class="px-6 py-3 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $order->nama }}</td>
                            <td class="px-6 py-3">{{ $order->luasarea }}</td>
                            <td class="px-6 py-3">{{ $order->notelp }}</td>
                            <td class="px-6 py-3">
                                {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-3">
    {{ $order->tank_type == 'tanam' ? 'Bak Tanam' : ($order->tank_type == 'fiber' ? 'Bak Fiber' : '-') }}
</td>

                            <td class="px-6 py-3">{{ $order->grade->gradeName }}</td>

                            <td class="px-6 py-3 flex gap-3">
                                <button class="btn-edit text-blue-600 hover:text-blue-900" data-id="{{ $order->id }}">
                                    ✏️
                                </button>
                                <button class="btn-delete text-red-600 hover:text-red-900"
                                    data-id="{{ $order->id }}"
                                    data-nama="{{ $order->nama }}">
                                    🗑️
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                Belum ada data pemesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <!-- ============================= -->
    <!-- MODAL TAMBAH -->
    <!-- ============================= -->
    <div id="modal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-[9999]">
        <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">

            <h2 class="text-xl font-semibold mb-4">Tambah Pemesanan</h2>

            <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✖</button>

            <form id="addForm" method="POST">@csrf

                <div class="mb-3">
                    <label>Nama Pemesan</label>
                    <input type="text" name="nama" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>Luas Area</label>
                    <input type="text" name="luasarea" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="notelp" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_order" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
    <label>Tipe Bak</label>
    <select name="tank_type"
        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
        <option value="tanam">Bak Tanam</option>
        <option value="fiber">Bak Fiber</option>
    </select>
</div>


                <div class="mb-3">
                    <label>Grade</label>
                    <select name="grade_id" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
    @foreach ($grades as $g)
        <option value="{{ $g->id }}">{{ $g->gradeName }}</option>
    @endforeach
</select>

                </div>

                <div class="mb-3">
                    <label>Catatan</label>
                    <input type="text" name="catatan" class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <button class="bg-blue-600 w-full text-white py-2 rounded-lg hover:bg-blue-700 mt-3">
                    Simpan
                </button>
            </form>
        </div>
    </div>


    <!-- ============================= -->
    <!-- MODAL EDIT -->
    <!-- ============================= -->
    <div id="editModal"
        class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-[9999]">
        <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">

            <h2 class="text-xl font-semibold mb-4">Edit Pemesanan</h2>

            <button id="closeEditModal"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✖</button>

            <form id="editForm">@csrf

                <div class="mb-3">
                    <label>Nama Pemesan</label>
                    <input type="text" name="nama" id="editNama"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>Luas Area</label>
                    <input type="text" name="luasarea" id="editLuas"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="notelp" id="editTelp"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-3">
                    <label>Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_order" id="editTanggal"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                </div>

               <div class="mb-3">
    <label>Tipe Bak</label>
    <select name="tank_type" id="editTankType"
        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
        <option value="tanam">Bak Tanam</option>
        <option value="fiber">Bak Fiber</option>
    </select>
</div>


                <div class="mb-3">
                    <label>Grade</label>
                    <select name="grade_id" id="editGrade"
                        class="w-full rounded-lg border p-2 focus:ring-2 focus:ring-blue-500">
                        @foreach ($grades as $g)
                        <option value="{{ $g->id }}">{{ $g->gradeName }}</option>
                        @endforeach
                    </select>
                </div>

                <button
                    class="bg-blue-600 w-full text-white py-2 rounded-lg hover:bg-blue-700 mt-3">
                    Simpan Perubahan
                </button>
            </form>

        </div>
    </div>


    <!-- ============================= -->
    <!-- MODAL DELETE -->
    <!-- ============================= -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-[9999]">
        <div class="bg-white w-80 p-5 rounded-2xl shadow-xl text-center">

            <h2 class="text-lg font-semibold mb-2">Hapus Pemesanan?</h2>

            <p id="deleteTarget" class="text-gray-500 mb-4"></p>

            <div class="flex justify-center gap-3">
                <button id="cancelDelete"
                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </button>

                <button id="confirmDelete"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Hapus
                </button>
            </div>

        </div>

    </div>

</body>
</html>
