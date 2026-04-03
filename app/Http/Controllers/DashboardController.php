<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ambil filter status dari query string (?status=...)
        $statusFilter = request()->query('status'); 
        // nilai bisa: Belum Mulai | Progress | Selesai | null (Semua)

        $ordersQuery = Order::with('grade')->latest();

        if ($statusFilter) {
            $ordersQuery->where('status', $statusFilter);
        }

        $orders = $ordersQuery->get();

        $visitors = Visitor::count();
        $totalOrders = Order::count();

        // hitung tiap status buat ditampilkan di dropdown / badge
        $countBelumMulai = Order::where('status', 'Belum Mulai')->count();
        $countProgress   = Order::where('status', 'Progress')->count();
        $countSelesai    = Order::where('status', 'Selesai')->count();

        return view('admin.dashboard', compact(
            'orders',
            'visitors',
            'totalOrders',
            'statusFilter',
            'countBelumMulai',
            'countProgress',
            'countSelesai'
        ));
    }
}
