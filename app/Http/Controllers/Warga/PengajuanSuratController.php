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
        $jenisSurat = SuratJenis::with('persyaratan')->get();
        return view('warga.pengajuan.create', compact('jenisSurat'));
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'surat_jenis_id' => 'required|exists:surat_jenis,id',
            'keperluan' => 'required|string|min:10|max:1000',
        ];

        // Get jenis surat dengan persyaratan
        $jenisSurat = SuratJenis::with('persyaratan')->find($request->surat_jenis_id);

        // Validasi persyaratan dinamis
        foreach ($jenisSurat->persyaratan as $persyaratan) {
            $fieldName = 'persyaratan_' . $persyaratan->id;

            if ($persyaratan->wajib) {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    $mimes = $persyaratan->tipe === 'image' ? 'jpeg,jpg,png' : 'jpeg,jpg,png,pdf';
                    $rules[$fieldName] = "required|file|mimes:{$mimes}|max:2048";
                } elseif ($persyaratan->tipe === 'date') {
                    $rules[$fieldName] = 'required|date';
                } else {
                    $rules[$fieldName] = 'required|string|max:1000';
                }
            } else {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    $mimes = $persyaratan->tipe === 'image' ? 'jpeg,jpg,png' : 'jpeg,jpg,png,pdf';
                    $rules[$fieldName] = "nullable|file|mimes:{$mimes}|max:2048";
                } elseif ($persyaratan->tipe === 'date') {
                    $rules[$fieldName] = 'nullable|date';
                } else {
                    $rules[$fieldName] = 'nullable|string|max:1000';
                }
            }
        }

        $validated = $request->validate($rules);

        // Handle persyaratan uploads dan simpan ke JSON
        $dataPersyaratan = [];
        foreach ($jenisSurat->persyaratan as $persyaratan) {
            $fieldName = 'persyaratan_' . $persyaratan->id;

            if ($request->has($fieldName) || $request->hasFile($fieldName)) {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    if ($request->hasFile($fieldName)) {
                        $file = $request->file($fieldName);
                        $userId = Auth::id();
                        $timestamp = time();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "persyaratan_{$persyaratan->id}_{$userId}_{$timestamp}.{$extension}";
                        $file->storeAs('dokumen_pengajuan', $filename, 'public');
                        $dataPersyaratan[$persyaratan->kode] = "dokumen_pengajuan/{$filename}";
                    }
                } else {
                    $dataPersyaratan[$persyaratan->kode] = $request->input($fieldName);
                }
            }
        }

        // Create pengajuan
        PengajuanSurat::create([
            'user_id' => Auth::id(),
            'surat_jenis_id' => $request->surat_jenis_id,
            'keperluan' => $request->keperluan,
            'data_persyaratan' => $dataPersyaratan,
            'status' => 'idle',
        ]);

        return redirect()->route('warga.pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dibuat dengan dokumen lengkap! Status: Menunggu verifikasi admin.');
    }

    private function addDocumentRules(array &$rules, string $jenisSurat): void
    {
        // Dokumen umum (semua jenis surat)
        $rules['dokumen_kk'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
        $rules['dokumen_ktp'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';

        // Dokumen khusus berdasarkan jenis surat
        switch ($jenisSurat) {
            case 'surat keterangan usaha':
                $rules['dokumen_foto_usaha'] = 'required|file|mimes:jpeg,jpg,png|max:2048';
                break;

            case 'surat keterangan tidak mampu':
                $rules['dokumen_foto_rumah'] = 'required|file|mimes:jpeg,jpg,png|max:2048';
                break;

            case 'surat pengantar skck':
                $rules['dokumen_pas_photo'] = 'required|file|mimes:jpeg,jpg,png|max:2048';
                break;

            case 'surat keterangan kematian':
                $rules['tanggal_meninggal'] = 'required|date|before_or_equal:today';
                $rules['tpu'] = 'required|string|max:255';
                break;

            case 'surat keterangan kelahiran':
                $rules['dokumen_ktp_ortu'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_ktp_ortu2'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_surat_lahir'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_buku_nikah'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_ktp_bersangkutan'] = 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048';
                break;

            case 'surat pengantar nikah':
                $rules['dokumen_ktp_bersangkutan'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_ktp_ortu'] = 'required|file|mimes:jpeg,jpg,png,pdf|max:2048';
                $rules['dokumen_surat_rekomendasi'] = 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048';
                break;
        }
    }

    private function handleDocumentUploads(Request $request, string $jenisSurat): array
    {
        $documentData = [];

        // Upload dokumen umum
        if ($request->hasFile('dokumen_kk')) {
            $documentData['dokumen_kk'] = $this->uploadFile($request->file('dokumen_kk'), 'kk');
        }
        if ($request->hasFile('dokumen_ktp')) {
            $documentData['dokumen_ktp'] = $this->uploadFile($request->file('dokumen_ktp'), 'ktp');
        }

        // Upload dokumen khusus
        switch ($jenisSurat) {
            case 'surat keterangan usaha':
                if ($request->hasFile('dokumen_foto_usaha')) {
                    $documentData['dokumen_foto_usaha'] = $this->uploadFile($request->file('dokumen_foto_usaha'), 'foto_usaha');
                }
                break;

            case 'surat keterangan tidak mampu':
                if ($request->hasFile('dokumen_foto_rumah')) {
                    $documentData['dokumen_foto_rumah'] = $this->uploadFile($request->file('dokumen_foto_rumah'), 'foto_rumah');
                }
                break;

            case 'surat pengantar skck':
                if ($request->hasFile('dokumen_pas_photo')) {
                    $documentData['dokumen_pas_photo'] = $this->uploadFile($request->file('dokumen_pas_photo'), 'pas_photo');
                }
                break;

            case 'surat keterangan kematian':
                $documentData['tanggal_meninggal'] = $request->tanggal_meninggal;
                $documentData['tpu'] = $request->tpu;
                break;

            case 'surat keterangan kelahiran':
                if ($request->hasFile('dokumen_ktp_ortu')) {
                    $documentData['dokumen_ktp_ortu'] = $this->uploadFile($request->file('dokumen_ktp_ortu'), 'ktp_ortu');
                }
                if ($request->hasFile('dokumen_ktp_ortu2')) {
                    $documentData['dokumen_ktp_ortu2'] = $this->uploadFile($request->file('dokumen_ktp_ortu2'), 'ktp_ortu2');
                }
                if ($request->hasFile('dokumen_surat_lahir')) {
                    $documentData['dokumen_surat_lahir'] = $this->uploadFile($request->file('dokumen_surat_lahir'), 'surat_lahir');
                }
                if ($request->hasFile('dokumen_buku_nikah')) {
                    $documentData['dokumen_buku_nikah'] = $this->uploadFile($request->file('dokumen_buku_nikah'), 'buku_nikah');
                }
                if ($request->hasFile('dokumen_ktp_bersangkutan')) {
                    $documentData['dokumen_ktp_bersangkutan'] = $this->uploadFile($request->file('dokumen_ktp_bersangkutan'), 'ktp_bersangkutan');
                }
                break;

            case 'surat pengantar nikah':
                if ($request->hasFile('dokumen_ktp_bersangkutan')) {
                    $documentData['dokumen_ktp_bersangkutan'] = $this->uploadFile($request->file('dokumen_ktp_bersangkutan'), 'ktp_bersangkutan');
                }
                if ($request->hasFile('dokumen_ktp_ortu')) {
                    $documentData['dokumen_ktp_ortu'] = $this->uploadFile($request->file('dokumen_ktp_ortu'), 'ktp_ortu');
                }
                if ($request->hasFile('dokumen_surat_rekomendasi')) {
                    $documentData['dokumen_surat_rekomendasi'] = $this->uploadFile($request->file('dokumen_surat_rekomendasi'), 'surat_rekomendasi');
                }
                break;
        }

        return $documentData;
    }

    private function uploadFile($file, string $prefix): string
    {
        $userId = Auth::id();
        $timestamp = time();
        $extension = $file->getClientOriginalExtension();
        $filename = "{$prefix}_{$userId}_{$timestamp}.{$extension}";

        $file->storeAs('dokumen_pengajuan', $filename, 'public');

        return "dokumen_pengajuan/{$filename}";
    }

    public function show($id): View
    {
        $userId = Auth::id();
        $pengajuan = PengajuanSurat::with(['suratJenis', 'user'])
            ->where('user_id', $userId)
            ->findOrFail($id);

        return view('warga.pengajuan.show', compact('pengajuan'));
    }

    public function edit($id): View
    {
        $userId = Auth::id();
        $pengajuan = PengajuanSurat::with(['suratJenis.persyaratan'])
            ->where('user_id', $userId)
            ->findOrFail($id);

        // Hanya bisa edit jika status masih idle
        if ($pengajuan->status !== 'idle') {
            abort(403, 'Pengajuan tidak dapat diubah karena sudah diproses.');
        }

        $jenisSurat = SuratJenis::with('persyaratan')->get();
        return view('warga.pengajuan.edit', compact('pengajuan', 'jenisSurat'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $userId = Auth::id();
        $pengajuan = PengajuanSurat::where('user_id', $userId)->findOrFail($id);

        // Hanya bisa update jika status masih idle
        if ($pengajuan->status !== 'idle') {
            return redirect()->back()
                ->with('error', 'Pengajuan tidak dapat diubah karena sudah diproses.');
        }

        $rules = [
            'surat_jenis_id' => 'required|exists:surat_jenis,id',
            'keperluan' => 'required|string|min:10|max:1000',
        ];

        // Get jenis surat dengan persyaratan
        $jenisSurat = SuratJenis::with('persyaratan')->find($request->surat_jenis_id);

        // Validasi persyaratan dinamis
        foreach ($jenisSurat->persyaratan as $persyaratan) {
            $fieldName = 'persyaratan_' . $persyaratan->id;

            if ($persyaratan->wajib) {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    $mimes = $persyaratan->tipe === 'image' ? 'jpeg,jpg,png' : 'jpeg,jpg,png,pdf';
                    $rules[$fieldName] = "nullable|file|mimes:{$mimes}|max:2048";
                } elseif ($persyaratan->tipe === 'date') {
                    $rules[$fieldName] = 'nullable|date';
                } else {
                    $rules[$fieldName] = 'nullable|string|max:1000';
                }
            } else {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    $mimes = $persyaratan->tipe === 'image' ? 'jpeg,jpg,png' : 'jpeg,jpg,png,pdf';
                    $rules[$fieldName] = "nullable|file|mimes:{$mimes}|max:2048";
                } elseif ($persyaratan->tipe === 'date') {
                    $rules[$fieldName] = 'nullable|date';
                } else {
                    $rules[$fieldName] = 'nullable|string|max:1000';
                }
            }
        }

        $validated = $request->validate($rules);

        // Get data persyaratan lama
        $dataPersyaratan = $pengajuan->data_persyaratan ?? [];

        // Handle persyaratan uploads dan update JSON
        foreach ($jenisSurat->persyaratan as $persyaratan) {
            $fieldName = 'persyaratan_' . $persyaratan->id;

            if ($request->has($fieldName) || $request->hasFile($fieldName)) {
                if ($persyaratan->tipe === 'file' || $persyaratan->tipe === 'image') {
                    if ($request->hasFile($fieldName)) {
                        // Hapus file lama jika ada
                        if (isset($dataPersyaratan[$persyaratan->kode]) && \Storage::disk('public')->exists($dataPersyaratan[$persyaratan->kode])) {
                            \Storage::disk('public')->delete($dataPersyaratan[$persyaratan->kode]);
                        }

                        // Upload file baru
                        $file = $request->file($fieldName);
                        $timestamp = time();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "persyaratan_{$persyaratan->id}_{$userId}_{$timestamp}.{$extension}";
                        $file->storeAs('dokumen_pengajuan', $filename, 'public');
                        $dataPersyaratan[$persyaratan->kode] = "dokumen_pengajuan/{$filename}";
                    }
                } else {
                    $dataPersyaratan[$persyaratan->kode] = $request->input($fieldName);
                }
            }
        }

        // Update pengajuan
        $pengajuan->update([
            'surat_jenis_id' => $request->surat_jenis_id,
            'keperluan' => $request->keperluan,
            'data_persyaratan' => $dataPersyaratan,
        ]);

        return redirect()->route('warga.pengajuan.show', $id)
            ->with('success', 'Pengajuan surat berhasil diperbarui!');
    }
}
