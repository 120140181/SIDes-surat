<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
        public function run()
    {
        // Buat admin
        User::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Admin Desa',
            'tempat_lahir' => 'Desa Harapan Jaya',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Kantor Desa Harapan Jaya',
            'agama' => 'Islam',
            'pekerjaan' => 'Pegawai Desa',
            'status_perkawinan' => 'Kawin',
            'kewarganegaraan' => 'Indonesia',
            'no_telepon' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Buat contoh warga
        User::create([
            'nik' => '9876543210987654',
            'nama_lengkap' => 'Warga Contoh',
            'tempat_lahir' => 'Desa Harapan Jaya',
            'tanggal_lahir' => '1985-05-15',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Merdeka No. 123, Desa Harapan Jaya',
            'agama' => 'Islam',
            'pekerjaan' => 'Ibu Rumah Tangga',
            'status_perkawinan' => 'Kawin',
            'kewarganegaraan' => 'Indonesia',
            'no_telepon' => '081298765432',
            'role' => 'warga',
            'password' => Hash::make('warga123'),
        ]);
    }
}
