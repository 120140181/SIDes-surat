<?php
// app/Http/Controllers/Admin/PengajuanSuratController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanSurat::with(['user', 'suratJenis'])
            ->latest()
            ->get();

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanSurat::with(['user', 'suratJenis'])
            ->findOrFail($id);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:idle,proses,selesai',
            'keterangan_admin' => 'nullable|string',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        return redirect()->route('admin.pengajuan.show', $id)
            ->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
