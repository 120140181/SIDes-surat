<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = User::where('role', 'warga')->count();
        $totalPengajuan = PengajuanSurat::count();
        $pengajuanIdle = PengajuanSurat::where('status', 'idle')->count();
        $pengajuanProses = PengajuanSurat::where('status', 'proses')->count();
        $pengajuanSelesai = PengajuanSurat::where('status', 'selesai')->count();

        $pengajuanTerbaru = PengajuanSurat::with(['user', 'suratJenis'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalWarga',
            'totalPengajuan',
            'pengajuanIdle',
            'pengajuanProses',
            'pengajuanSelesai',
            'pengajuanTerbaru'
        ));
    }
}
