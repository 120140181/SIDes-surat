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
            'no_telepon' => '08123123123',
            'role' => 'admin',
            'password' => Hash::make('admin@017342'),
        ]);
    }
}
