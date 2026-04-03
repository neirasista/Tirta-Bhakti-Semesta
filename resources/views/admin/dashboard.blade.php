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

                <!-- Company Profile -->
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

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">

            <!-- STATS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 mb-6">

                <!-- Visitors -->
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md">
                    <p class="text-xs text-gray-500">Pengunjung Website</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $visitors }}</h3>
                    <p class="text-[11px] text-gray-400">Total pengunjung</p>
                </div>

                <!-- Simulasi (dummy sementara) -->
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md">
                    <p class="text-xs text-gray-500">Jumlah Pengguna Simulasi</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">0</h3>
                    <p class="text-[11px] text-gray-400">Data simulasi</p>
                </div>

                <!-- Total Proyek -->
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-md">
                    <p class="text-xs text-gray-500">Total Proyek</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $totalOrders }}</h3>
                    <p class="text-[11px] text-gray-400">Total pesanan</p>
                </div>

            </div>

            <!-- LIST PEKERJAAN -->
            <h2 class="text-2xl font-bold mb-3">List Pekerjaan</h2>
<form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3 flex items-center gap-2">
    <label class="text-sm text-gray-600">Filter Status:</label>

    <select name="status"
        onchange="this.form.submit()"
        class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua</option>
        <option value="Belum Mulai" {{ ($statusFilter ?? '')=='Belum Mulai' ? 'selected' : '' }}>
            Belum Mulai ({{ $countBelumMulai }})
        </option>
        <option value="Progress" {{ ($statusFilter ?? '')=='Progress' ? 'selected' : '' }}>
            Progress ({{ $countProgress }})
        </option>
        <option value="Selesai" {{ ($statusFilter ?? '')=='Selesai' ? 'selected' : '' }}>
            Selesai ({{ $countSelesai }})
        </option>
    </select>
</form>

            <div class="rounded-lg shadow-md bg-white">
                <div class="overflow-visible rounded-lg">
                    <table class="min-w-full text-sm text-left text-gray-700 border-separate border-spacing-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3">Nama Pekerjaan</th>
                                <th class="px-6 py-3">Jenis</th>
                                <th class="px-6 py-3">Tanggal Order</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-300/30">
                            @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50">

                                <!-- NAMA -->
                                <td class="px-6 py-4">{{ $order->nama }}</td>

                                <!-- JENIS = Grade -->
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                        {{ $order->grade->gradeName }}
                                    </span>
                                </td>

                                <!-- DEADLINE -->
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d-m-Y') }}
                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-4 relative">
                                    <button onclick="toggleStatusMenu(this)"
                                            data-menu="status-{{ $order->id }}"
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $order->status=='Belum Mulai' ? 
                                                'bg-red-100 text-red-700' : 
                                               ($order->status=='Progress' ? 
                                                'bg-yellow-100 text-yellow-700' : 
                                                'bg-green-100 text-green-700') }}">
                                        {{ $order->status }}
                                    </button>

                                    <div id="status-{{ $order->id }}"
                                         class="hidden absolute mt-2 bg-white border shadow w-32 rounded-lg z-10">

                                        <button onclick="updateStatus({{ $order->id }}, 'Belum Mulai')"
                                                class="block w-full text-left px-3 py-1 text-xs hover:bg-gray-100">
                                            Belum Mulai
                                        </button>

                                        <button onclick="updateStatus({{ $order->id }}, 'Progress')"
                                                class="block w-full text-left px-3 py-1 text-xs hover:bg-gray-100">
                                            Progress
                                        </button>

                                        <button onclick="updateStatus({{ $order->id }}, 'Selesai')"
                                                class="block w-full text-left px-3 py-1 text-xs hover:bg-gray-100">
                                            Selesai
                                        </button>

                                    </div>
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-4 flex gap-3">
                                    <button onclick="deleteOrder({{ $order->id }})"
                                            class="text-red-600 hover:text-red-800">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </main>

    </div>

    <script>
        function toggleStatusMenu(btn) {
            const id = btn.getAttribute("data-menu");
            document.getElementById(id).classList.toggle("hidden");
        }

        async function updateStatus(id, status) {
            await fetch(`/admin/orderdata/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-HTTP-Method-Override": "PUT",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ status })
            });

            window.location.reload();
        }

        async function deleteOrder(id) {
            if (!confirm("Yakin hapus pekerjaan ini?")) return;

            await fetch(`/admin/orderdata/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-HTTP-Method-Override": "DELETE"
                }
            });

            window.location.reload();
        }
    </script>

</body>
</html>
