<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa  = Mahasiswa::count();
        $mahasiswaBaru   = Mahasiswa::whereMonth('created_at', now()->month)->count();

        // Status breakdown
        $statusCounts = Mahasiswa::select('status', DB::raw('count(*) as total'))
                                 ->groupBy('status')
                                 ->pluck('total', 'status');

        // Per-prodi count (top 5)
        $perProdi = Prodi::withCount('mahasiswas')
                         ->orderByDesc('mahasiswas_count')
                         ->take(5)->get();

        $latestMahasiswa = Mahasiswa::with('prodi')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalMahasiswa',
            'mahasiswaBaru',
            'statusCounts',
            'perProdi',
            'latestMahasiswa'
        ));
    }
}
