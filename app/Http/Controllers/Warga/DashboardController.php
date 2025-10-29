<?php
// app/Http/Controllers/Warga/DashboardController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $userId = $user->id;

        $totalPengajuan = PengajuanSurat::where('user_id', $userId)->count();
        $pengajuanSelesai = PengajuanSurat::where('user_id', $userId)
            ->where('status', 'selesai')->count();
        $pengajuanProses = PengajuanSurat::where('user_id', $userId)
            ->where('status', 'proses')->count();
        $pengajuanMenunggu = PengajuanSurat::where('user_id', $userId)
            ->where('status', 'idle')->count();

        $pengajuanTerbaru = PengajuanSurat::with('suratJenis')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('warga.dashboard', compact(
            'user',
            'totalPengajuan',
            'pengajuanSelesai',
            'pengajuanProses',
            'pengajuanMenunggu',
            'pengajuanTerbaru'
        ));
    }
}
