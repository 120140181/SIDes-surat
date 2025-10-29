<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'kewarganegaraan',
        'no_telepon',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'password' => 'hashed',
        ];
    }

    // Accessor untuk format tampilan
    public function getFormattedTanggalLahirAttribute()
    {
        return $this->tanggal_lahir->format('d/m/Y');
    }

    public function getFormattedJenisKelaminAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Method untuk cek apakah profile sudah lengkap
    public function isProfileComplete()
    {
        return !empty($this->alamat) &&
            !empty($this->agama) &&
            !empty($this->pekerjaan) &&
            !empty($this->status_perkawinan) &&
            !empty($this->no_telepon);
    }

    // Relasi dengan pengajuan surat
    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}
