<?php
// app/Http/Controllers/Warga/PengajuanSuratController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\SuratJenis;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PengajuanSuratController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $pengajuan = PengajuanSurat::with('suratJenis')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('warga.pengajuan.index', compact('pengajuan'));
    }

    public function create(): View
    {
        $jenisSurat = SuratJenis::all();
        return view('warga.pengajuan.create', compact('jenisSurat'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'surat_jenis_id' => 'required|exists:surat_jenis,id',
            'keperluan' => 'required|string|min:10|max:1000',
        ]);

        PengajuanSurat::create([
            'user_id' => Auth::id(),
            'surat_jenis_id' => $request->surat_jenis_id,
            'keperluan' => $request->keperluan,
            'status' => 'idle',
        ]);

        return redirect()->route('warga.pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dibuat! Status: Menunggu verifikasi admin.');
    }

    public function show($id): View
    {
        $userId = Auth::id();
        $pengajuan = PengajuanSurat::with(['suratJenis', 'user'])
            ->where('user_id', $userId)
            ->findOrFail($id);

        return view('warga.pengajuan.show', compact('pengajuan'));
    }
}
