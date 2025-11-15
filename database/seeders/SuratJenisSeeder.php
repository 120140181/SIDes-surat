<?php
// database/seeders/SuratJenisSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SuratJenis;

class SuratJenisSeeder extends Seeder
{
    public function run()
    {
        $jenisSurat = [
            ['nama' => 'Surat Keterangan Usaha'],
            ['nama' => 'Surat Keterangan Tidak Mampu'],
            ['nama' => 'Surat Keterangan Domisili'],
            ['nama' => 'Surat Keterangan Kelahiran'],
            ['nama' => 'Surat Keterangan Kematian'],
            ['nama' => 'Surat Pengantar SKCK'],
            ['nama' => 'Surat Pengantar Nikah'],
        ];

        foreach ($jenisSurat as $jenis) {
            SuratJenis::create($jenis);
        }
    }
}
