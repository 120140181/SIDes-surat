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
        $rules = [
            'surat_jenis_id' => 'required|exists:surat_jenis,id',
            'keperluan' => 'required|string|min:10|max:1000',
        ];

        // Get jenis surat to determine required documents
        $jenisSurat = SuratJenis::find($request->surat_jenis_id);
        $jenisSuratNama = strtolower($jenisSurat->nama ?? '');

        // Add document validation rules based on jenis surat
        $this->addDocumentRules($rules, $jenisSuratNama);

        $validated = $request->validate($rules);

        // Handle file uploads
        $documentData = $this->handleDocumentUploads($request, $jenisSuratNama);

        // Create pengajuan with all data
        PengajuanSurat::create([
            'user_id' => Auth::id(),
            'surat_jenis_id' => $request->surat_jenis_id,
            'keperluan' => $request->keperluan,
            'status' => 'idle',
            ...$documentData
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

            case 'skck':
                $rules['dokumen_pas_photo'] = 'required|file|mimes:jpeg,jpg,png|max:2048';
                break;

            case 'surat kematian':
                $rules['tanggal_meninggal'] = 'required|date|before_or_equal:today';
                $rules['tpu'] = 'required|string|max:255';
                break;

            case 'surat kelahiran':
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

            case 'skck':
                if ($request->hasFile('dokumen_pas_photo')) {
                    $documentData['dokumen_pas_photo'] = $this->uploadFile($request->file('dokumen_pas_photo'), 'pas_photo');
                }
                break;

            case 'surat kematian':
                $documentData['tanggal_meninggal'] = $request->tanggal_meninggal;
                $documentData['tpu'] = $request->tpu;
                break;

            case 'surat kelahiran':
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
}
