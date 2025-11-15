<?php
// app/Http/Controllers/Admin/JenisSuratController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratJenis;
use App\Models\SuratPersyaratan;
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

    // Manage persyaratan
    public function persyaratan($id): View
    {
        $jenisSurat = SuratJenis::with('persyaratan')->findOrFail($id);
        return view('admin.data.jenis-surat-persyaratan', compact('jenisSurat'));
    }

    public function storePersyaratan(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tipe' => 'required|in:file,image,text,date,textarea',
            'wajib' => 'required|boolean',
            'keterangan' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $id,
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tipe' => $request->tipe,
            'wajib' => $request->wajib,
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan
        ]);

        return redirect()->route('admin.data.jenis-surat-persyaratan', $id)
            ->with('success', 'Persyaratan berhasil ditambahkan!');
    }

    public function updatePersyaratan(Request $request, $jenisId, $persyaratanId): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'tipe' => 'required|in:file,image,text,date,textarea',
            'wajib' => 'required|boolean',
            'keterangan' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        $persyaratan = SuratPersyaratan::where('surat_jenis_id', $jenisId)
            ->findOrFail($persyaratanId);

        $persyaratan->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'tipe' => $request->tipe,
            'wajib' => $request->wajib,
            'keterangan' => $request->keterangan,
            'urutan' => $request->urutan
        ]);

        return redirect()->route('admin.data.jenis-surat-persyaratan', $jenisId)
            ->with('success', 'Persyaratan berhasil diperbarui!');
    }

    public function destroyPersyaratan($jenisId, $persyaratanId): RedirectResponse
    {
        $persyaratan = SuratPersyaratan::where('surat_jenis_id', $jenisId)
            ->findOrFail($persyaratanId);

        $persyaratan->delete();

        return redirect()->route('admin.data.jenis-surat-persyaratan', $jenisId)
            ->with('success', 'Persyaratan berhasil dihapus!');
    }
}
