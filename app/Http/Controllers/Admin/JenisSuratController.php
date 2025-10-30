<?php
// app/Http/Controllers/Admin/JenisSuratController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratJenis;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JenisSuratController extends Controller
{
    public function index(): View
    {
        $jenisSurat = SuratJenis::latest()->get();
        return view('admin.data.jenis-surat', compact('jenisSurat'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:surat_jenis,nama',
        ]);

        SuratJenis::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.data.jenis-surat')
            ->with('success', 'Jenis surat berhasil ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:surat_jenis,nama,' . $id,
        ]);

        $jenisSurat = SuratJenis::findOrFail($id);
        $jenisSurat->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.data.jenis-surat')
            ->with('success', 'Jenis surat berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $jenisSurat = SuratJenis::findOrFail($id);

        // Cek apakah jenis surat sedang digunakan
        if ($jenisSurat->pengajuanSurat()->exists()) {
            return redirect()->route('admin.data.jenis-surat')
                ->with('error', 'Tidak dapat menghapus jenis surat yang sedang digunakan dalam pengajuan!');
        }

        $jenisSurat->delete();

        return redirect()->route('admin.data.jenis-surat')
            ->with('success', 'Jenis surat berhasil dihapus!');
    }
}
