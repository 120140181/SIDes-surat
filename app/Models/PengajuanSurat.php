<?php
// app/Models/PengajuanSurat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id',
        'surat_jenis_id',
        'keperluan',
        'status',
        'keterangan_admin'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

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
