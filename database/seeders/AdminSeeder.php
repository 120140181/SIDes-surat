<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin_des1
        User::create([
            'nik' => '0000000000000002',
            'email' => 'admin_des1',
            'password' => Hash::make('admin@1ok'),
            'nama_lengkap' => 'Admin Desa 1',
            'role' => 'admin',
            'tempat_lahir' => 'Lampung',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
        ]);

        echo "✅ Admin baru berhasil dibuat!\n";
        echo "Username: admin_des1\n";
        echo "Password: admin@1ok\n";
    }
}
