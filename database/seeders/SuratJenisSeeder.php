<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratJenis;
use App\Models\SuratPersyaratan;

class SuratJenisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Surat Keterangan Domisili
        $domisili = SuratJenis::create([
            'nama' => 'Surat Keterangan Domisili',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $domisili->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $domisili->id,
            'nama' => 'KTP Pemohon',
            'kode' => 'dokumen_ktp',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP yang masih berlaku',
            'urutan' => 2,
        ]);

        // 2. Surat Keterangan Usaha
        $usaha = SuratJenis::create([
            'nama' => 'Surat Keterangan Usaha',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $usaha->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $usaha->id,
            'nama' => 'KTP Pemohon',
            'kode' => 'dokumen_ktp',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP yang masih berlaku',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $usaha->id,
            'nama' => 'Foto Usaha',
            'kode' => 'dokumen_foto_usaha',
            'tipe' => 'image',
            'wajib' => true,
            'keterangan' => 'Upload foto usaha tampak depan atau aktivitas usaha',
            'urutan' => 3,
        ]);

        // 3. Surat Keterangan Tidak Mampu (SKTM)
        $sktm = SuratJenis::create([
            'nama' => 'Surat Keterangan Tidak Mampu',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $sktm->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $sktm->id,
            'nama' => 'KTP Pemohon',
            'kode' => 'dokumen_ktp',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP yang masih berlaku',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $sktm->id,
            'nama' => 'Foto Rumah',
            'kode' => 'dokumen_foto_rumah',
            'tipe' => 'image',
            'wajib' => true,
            'keterangan' => 'Upload foto rumah tampak depan, samping, dan kondisi lantai',
            'urutan' => 3,
        ]);

        // 4. SKCK (Surat Keterangan Catatan Kepolisian)
        $skck = SuratJenis::create([
            'nama' => 'Surat Pengantar SKCK',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $skck->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $skck->id,
            'nama' => 'KTP Pemohon',
            'kode' => 'dokumen_ktp',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP yang masih berlaku',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $skck->id,
            'nama' => 'Pas Foto 3x4 Latar Biru',
            'kode' => 'dokumen_pas_photo',
            'tipe' => 'image',
            'wajib' => true,
            'keterangan' => 'Upload pas foto ukuran 3x4 dengan latar belakang biru',
            'urutan' => 3,
        ]);

        // 5. Surat Keterangan Kematian
        $kematian = SuratJenis::create([
            'nama' => 'Surat Keterangan Kematian',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kematian->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kematian->id,
            'nama' => 'KTP Pemohon',
            'kode' => 'dokumen_ktp',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP pelapor',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kematian->id,
            'nama' => 'Tanggal Meninggal',
            'kode' => 'tanggal_meninggal',
            'tipe' => 'date',
            'wajib' => true,
            'keterangan' => 'Masukkan tanggal meninggal dunia',
            'urutan' => 3,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kematian->id,
            'nama' => 'Tempat Pemakaman (TPU)',
            'kode' => 'tpu',
            'tipe' => 'text',
            'wajib' => true,
            'keterangan' => 'Masukkan nama tempat pemakaman umum atau lokasi pemakaman',
            'urutan' => 4,
        ]);

        // 6. Surat Keterangan Kelahiran
        $kelahiran = SuratJenis::create([
            'nama' => 'Surat Keterangan Kelahiran',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'KTP Ayah',
            'kode' => 'dokumen_ktp_ortu',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP ayah',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'KTP Ibu',
            'kode' => 'dokumen_ktp_ortu2',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KTP ibu',
            'urutan' => 3,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'Surat Keterangan Lahir dari Dokter/Bidan',
            'kode' => 'dokumen_surat_lahir',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload surat keterangan lahir dari dokter atau bidan',
            'urutan' => 4,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'Buku Nikah Orang Tua',
            'kode' => 'dokumen_buku_nikah',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto buku nikah orang tua',
            'urutan' => 5,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $kelahiran->id,
            'nama' => 'KTP Anak (jika sudah punya)',
            'kode' => 'dokumen_ktp_bersangkutan',
            'tipe' => 'file',
            'wajib' => false,
            'keterangan' => 'Upload KTP anak jika sudah memiliki',
            'urutan' => 6,
        ]);

        // 7. Surat Pengantar Nikah
        $nikah = SuratJenis::create([
            'nama' => 'Surat Pengantar Nikah',
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $nikah->id,
            'nama' => 'Kartu Keluarga (KK)',
            'kode' => 'dokumen_kk',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload scan atau foto KK yang jelas',
            'urutan' => 1,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $nikah->id,
            'nama' => 'KTP Calon Pengantin',
            'kode' => 'dokumen_ktp_bersangkutan',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload KTP calon pengantin yang akan menikah',
            'urutan' => 2,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $nikah->id,
            'nama' => 'KTP Orang Tua',
            'kode' => 'dokumen_ktp_ortu',
            'tipe' => 'file',
            'wajib' => true,
            'keterangan' => 'Upload KTP orang tua calon pengantin',
            'urutan' => 3,
        ]);

        SuratPersyaratan::create([
            'surat_jenis_id' => $nikah->id,
            'nama' => 'Surat Rekomendasi dari Luar',
            'kode' => 'dokumen_surat_rekomendasi',
            'tipe' => 'file',
            'wajib' => false,
            'keterangan' => 'Upload surat rekomendasi jika numpang nikah dari desa lain',
            'urutan' => 4,
        ]);

        $this->command->info('✅ Seeder SuratJenis berhasil dijalankan!');
        $this->command->info('📝 Total ' . SuratJenis::count() . ' jenis surat dibuat');
        $this->command->info('📋 Total ' . SuratPersyaratan::count() . ' persyaratan dibuat');
    }
}
