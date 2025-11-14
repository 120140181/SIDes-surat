<?php
// database/migrations/2025_11_14_000001_add_documents_to_pengajuan_surat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            // Dokumen umum (untuk semua jenis surat)
            $table->string('dokumen_kk')->nullable()->after('keperluan');
            $table->string('dokumen_ktp')->nullable()->after('dokumen_kk');

            // Dokumen khusus
            $table->string('dokumen_foto_usaha')->nullable()->after('dokumen_ktp');
            $table->string('dokumen_foto_rumah')->nullable()->after('dokumen_foto_usaha');
            $table->string('dokumen_pas_photo')->nullable()->after('dokumen_foto_rumah');
            $table->string('dokumen_ktp_ortu')->nullable()->after('dokumen_pas_photo');
            $table->string('dokumen_ktp_ortu2')->nullable()->after('dokumen_ktp_ortu');
            $table->string('dokumen_surat_lahir')->nullable()->after('dokumen_ktp_ortu2');
            $table->string('dokumen_buku_nikah')->nullable()->after('dokumen_surat_lahir');
            $table->string('dokumen_ktp_bersangkutan')->nullable()->after('dokumen_buku_nikah');
            $table->string('dokumen_surat_rekomendasi')->nullable()->after('dokumen_ktp_bersangkutan');

            // Data tambahan untuk beberapa jenis surat
            $table->date('tanggal_meninggal')->nullable()->after('dokumen_surat_rekomendasi');
            $table->string('tpu')->nullable()->after('tanggal_meninggal');
        });
    }

    public function down()
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_kk',
                'dokumen_ktp',
                'dokumen_foto_usaha',
                'dokumen_foto_rumah',
                'dokumen_pas_photo',
                'dokumen_ktp_ortu',
                'dokumen_ktp_ortu2',
                'dokumen_surat_lahir',
                'dokumen_buku_nikah',
                'dokumen_ktp_bersangkutan',
                'dokumen_surat_rekomendasi',
                'tanggal_meninggal',
                'tpu'
            ]);
        });
    }
};
