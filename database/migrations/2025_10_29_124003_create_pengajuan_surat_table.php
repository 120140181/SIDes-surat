<?php
// database/migrations/[...]_create_pengajuan_surat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('surat_jenis_id')->constrained()->onDelete('cascade');
            $table->text('keperluan');
            $table->enum('status', ['idle', 'proses', 'selesai'])->default('idle');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
