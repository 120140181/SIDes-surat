<?php
// app/Http/Controllers/Admin/PengajuanSuratController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PengajuanSuratController extends Controller
{
    public function index(Request $request): View
    {
        $query = PengajuanSurat::with(['user', 'suratJenis'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->get();
        $totalPengajuan = $pengajuan->count();

        return view('admin.pengajuan.index', compact('pengajuan', 'totalPengajuan'));
    }

    public function show($id): View
    {
        $pengajuan = PengajuanSurat::with(['user', 'suratJenis.persyaratan'])
            ->findOrFail($id);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:idle,proses,selesai',
            'keterangan_admin' => 'nullable|string|max:500',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        $statusLabels = [
            'idle' => 'Menunggu',
            'proses' => 'Sedang Diproses',
            'selesai' => 'Selesai'
        ];

        return redirect()->route('admin.pengajuan.show', $id)
            ->with('success', "Status pengajuan berhasil diubah menjadi: {$statusLabels[$request->status]}");
    }

    public function destroy($id): RedirectResponse
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $nomorPengajuan = $pengajuan->id;
        $namaWarga = $pengajuan->user->nama_lengkap ?? 'Unknown';

        // Delete akan trigger event di model untuk hapus files
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')
            ->with('success', "Pengajuan #$nomorPengajuan dari $namaWarga berhasil dihapus beserta semua dokumennya.");
    }
}
