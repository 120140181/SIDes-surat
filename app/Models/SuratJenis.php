<?php
// app/Models/SuratJenis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJenis extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'surat_jenis';

    protected $fillable = ['nama'];

    // Relasi dengan pengajuan surat
    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}
