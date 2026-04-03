<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Grade;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman tabel order untuk ADMIN
     */
    public function index()
    {
        $orders = Order::with('grade')->latest()->get();
        $grades = Grade::all();

        return view('admin.orderdata', compact('orders', 'grades'));
    }

    /**
     * Halaman Form Pemesanan (khusus admin)
     */
    public function create()
    {
        $grades = Grade::all();
        return view('admin.pemesanan', compact('grades'));
    }

    /**
     * Simpan pesanan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'luasarea'      => 'required|string|max:50',
            'notelp'        => 'required|string|max:20',
            'tanggal_order' => 'required|date',
            'catatan'       => 'nullable|string',

            // bisa dari pemesanan.blade (grade) atau modal (grade_id)
            'grade'         => 'nullable|exists:grades,id',
            'grade_id'      => 'nullable|exists:grades,id',

            'tank_type'     => 'required|in:tanam,fiber',
        ]);

        $gradeId = $validated['grade_id'] ?? $validated['grade'] ?? null;

        Order::create([
            'nama'          => $validated['nama'],
            'luasarea'      => $validated['luasarea'],
            'notelp'        => $validated['notelp'],
            'tanggal_order' => $validated['tanggal_order'],
            'catatan'       => $validated['catatan'] ?? null,
            'grade_id'      => $gradeId,
            'tank_type'     => $validated['tank_type'],
            'status'        => 'Belum Mulai',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('admin.orderdata.index')
            ->with('success', 'Pesanan berhasil disimpan!');
    }

    /**
     * Ambil data 1 order untuk modal EDIT (AJAX)
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    /**
     * Update data order (AJAX / partial update)
     * ✅ sekarang boleh update status saja dari dashboard
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            // ✅ pakai sometimes biar gak wajib kalau tidak dikirim
            'nama'          => 'sometimes|required|string|max:255',
            'luasarea'      => 'sometimes|nullable|string|max:50',
            'notelp'        => 'sometimes|nullable|string|max:20',
            'tanggal_order' => 'sometimes|nullable|date',
            'catatan'       => 'sometimes|nullable|string',
            'grade_id'      => 'sometimes|nullable|exists:grades,id',
            'tank_type'     => 'sometimes|nullable|in:tanam,fiber',
            'status'        => 'sometimes|nullable|in:Belum Mulai,Progress,Selesai',
        ]);

        $order->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus data order (AJAX)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => true]);
    }
}
