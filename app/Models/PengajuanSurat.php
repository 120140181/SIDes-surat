<?php
// app/Models/PengajuanSurat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PengajuanSurat extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id',
        'surat_jenis_id',
        'keperluan',
        'data_persyaratan',
        'status',
        'keterangan_admin',
        // Dokumen umum
        'dokumen_kk',
        'dokumen_ktp',
        // Dokumen khusus
        'dokumen_foto_usaha',
        'dokumen_foto_rumah',
        'dokumen_pas_photo',
        'dokumen_ktp_ortu',
        'dokumen_ktp_ortu2',
        'dokumen_surat_lahir',
        'dokumen_buku_nikah',
        'dokumen_ktp_bersangkutan',
        'dokumen_surat_rekomendasi',
        // Data tambahan
        'tanggal_meninggal',
        'tpu'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'data_persyaratan' => 'array',
    ];

    /**
     * Boot the model and register events.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-delete files saat record dihapus
        static::deleting(function ($pengajuan) {
            // Delete files dari data_persyaratan (JSON)
            if ($pengajuan->data_persyaratan && is_array($pengajuan->data_persyaratan)) {
                foreach ($pengajuan->data_persyaratan as $filePath) {
                    if (is_string($filePath) && Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            // Delete dokumen fields lama (backward compatibility)
            $documentFields = [
                'dokumen_kk', 'dokumen_ktp', 'dokumen_foto_usaha', 'dokumen_foto_rumah',
                'dokumen_pas_photo', 'dokumen_ktp_ortu', 'dokumen_ktp_ortu2',
                'dokumen_surat_lahir', 'dokumen_buku_nikah', 'dokumen_ktp_bersangkutan',
                'dokumen_surat_rekomendasi'
            ];

            foreach ($documentFields as $field) {
                if ($pengajuan->$field && Storage::disk('public')->exists($pengajuan->$field)) {
                    Storage::disk('public')->delete($pengajuan->$field);
                }
            }
        });
    }

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan jenis surat
    public function suratJenis()
    {
        return $this->belongsTo(SuratJenis::class);
    }

    // Accessor untuk status dengan label lebih friendly
    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'idle' => 'Menunggu',
            'proses' => 'Sedang Diproses',
            'selesai' => 'Selesai - Dapat Diambil'
        ];

        return $statusLabels[$this->status] ?? $this->status;
    }
}
