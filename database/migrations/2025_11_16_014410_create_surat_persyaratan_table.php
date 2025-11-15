<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_jenis_id')->constrained('surat_jenis')->onDelete('cascade');
            $table->string('nama'); // Nama persyaratan (contoh: "KK", "Foto Usaha")
            $table->string('kode'); // Kode untuk field database (contoh: "dokumen_kk", "dokumen_foto_usaha")
            $table->enum('tipe', ['file', 'image', 'text', 'date', 'textarea']); // Tipe input
            $table->boolean('wajib')->default(true); // Apakah wajib atau tidak
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->integer('urutan')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_persyaratan');
    }
};
