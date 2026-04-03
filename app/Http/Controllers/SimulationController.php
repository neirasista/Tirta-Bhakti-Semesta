<?php

namespace App\Http\Controllers;

use App\Models\Simulation;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * USER: tampilkan halaman form simulasi
     * Route: GET /simulasibiaya
     */
    public function form()
    {
        return view('simulasi.simulasibiaya');
    }

    /**
     * USER: proses simulasi dari form (web)
     * Route: POST /simulasibiaya
     */
    public function runWeb(Request $request)
    {
        $data = $request->validate([
            'water_flow_rate' => 'required|numeric|min:0',
            'tank_type'       => 'required|in:tanam,fiber',
        ]);

        // ✅ kategori otomatis dari debit air
        $category = $this->determineInstallationCategory($data['water_flow_rate']);

        // ✅ budget SELALU dihitung otomatis
        $estimatedBudget = $this->estimateBudget(
            $data['water_flow_rate'],
            $category,
            $data['tank_type']
        );

        $summary = $this->calculateSummary(
            $data['water_flow_rate'],
            $category,
            $data['tank_type'],
            $estimatedBudget
        );

        $simulation = Simulation::create([
            'water_flow_rate'       => $data['water_flow_rate'],
            'installation_category' => $category,
            'budget'                => $estimatedBudget,
            'tank_type'             => $data['tank_type'],
            'result_summary'        => $summary,
            'visitor_id'            => null, // publik
        ]);

        return redirect('/simulasihasil')->with('simulation', $simulation);
    }

    /**
     * API versi publik / lama tetap aman dipakai via /api/simulation/run
     * Budget juga auto (kalau field budget di API dikirim, kita abaikan)
     */
    public function run(Request $request)
    {
        $data = $request->validate([
            'water_flow_rate' => 'required|numeric|min:0',
            'tank_type'       => 'nullable|in:tanam,fiber',
            'visitor_id'      => 'nullable|string',
        ]);

        $tankType = $data['tank_type'] ?? 'tanam';
        $category = $this->determineInstallationCategory($data['water_flow_rate']);

        $estimatedBudget = $this->estimateBudget(
            $data['water_flow_rate'],
            $category,
            $tankType
        );

        $summary = $this->calculateSummary(
            $data['water_flow_rate'],
            $category,
            $tankType,
            $estimatedBudget
        );

        $simulation = Simulation::create([
            'water_flow_rate'       => $data['water_flow_rate'],
            'installation_category' => $category,
            'budget'                => $estimatedBudget,
            'tank_type'             => $tankType,
            'result_summary'        => $summary,
            'visitor_id'            => $data['visitor_id'] ?? null,
        ]);

        return response()->json($simulation, 201);
    }

    // =========================
    // Helpers
    // =========================

    private function determineInstallationCategory(float $flowRate): string
    {
        // ✅ aturan sementara (silakan adjust nanti sesuai mitra)
        if ($flowRate <= 100) return 'Kecil';
        if ($flowRate <= 300) return 'Sedang';
        return 'Besar';
    }

    private function estimateBudget(float $flowRate, string $category, string $tankType): float
    {
        // ✅ dummy logika biaya:
        $basePerM3 = match ($category) {
            'Kecil'  => 250000,
            'Sedang' => 350000,
            'Besar'  => 450000,
            default  => 300000,
        };

        $tankMultiplier = $tankType === 'fiber' ? 1.15 : 1.0;

        return $flowRate * $basePerM3 * $tankMultiplier;
    }

    private function calculateSummary(float $flowRate, string $category, string $tankType, float $budget): string
    {
        $tankLabel = $tankType === 'fiber' ? 'Bak Fiber' : 'Bak Tanam';
        $budgetFormatted = number_format($budget, 0, ',', '.');

        return "Debit air {$flowRate} m³ termasuk instalasi {$category}. "
             . "Dengan tipe {$tankLabel}, estimasi biaya sekitar Rp {$budgetFormatted}.";
    }

    // =========================
    // ADMIN STATS (tetap aman)
    // =========================

    public function stats()
    {
        $totalRuns = Simulation::count();
        $simVisitors = Simulation::whereNotNull('visitor_id')
            ->distinct('visitor_id')
            ->count('visitor_id');

        $totalVisitors = \App\Models\Visitor::count();

        return response()->json([
            'total_runs' => $totalRuns,
            'unique_simulation_visitors' => $simVisitors,
            'total_visitors_web' => $totalVisitors
        ]);
    }

    public function index()
    {
        return Simulation::orderBy('created_at', 'desc')->get();
    }

    public function show(Simulation $simulation)
    {
        return $simulation;
    }
}
