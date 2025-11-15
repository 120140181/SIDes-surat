<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'surat_persyaratan';

    protected $fillable = [
        'surat_jenis_id',
        'nama',
        'kode',
        'tipe',
        'wajib',
        'keterangan',
        'urutan'
    ];

    protected $casts = [
        'wajib' => 'boolean',
        'urutan' => 'integer'
    ];

    // Relasi dengan surat jenis
    public function suratJenis()
    {
        return $this->belongsTo(SuratJenis::class);
    }

    // Accessor untuk label wajib
    public function getWajibLabelAttribute()
    {
        return $this->wajib ? 'Wajib' : 'Opsional';
    }

    // Accessor untuk tipe label
    public function getTipeLabelAttribute()
    {
        $labels = [
            'file' => 'File (PDF, JPG, PNG)',
            'image' => 'Gambar (JPG, PNG)',
            'text' => 'Teks',
            'date' => 'Tanggal',
            'textarea' => 'Teks Panjang'
        ];
        return $labels[$this->tipe] ?? $this->tipe;
    }
}
