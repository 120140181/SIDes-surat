<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Tambah kolom temporary untuk backup
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->string('status_temp', 50)->nullable()->after('status');
        });

        // Step 2: Backup data ke kolom temp
        DB::table('pengajuan_surat')->update(['status_temp' => DB::raw('status')]);

        // Step 3: Alter enum dengan tambah nilai baru
        DB::statement("ALTER TABLE pengajuan_surat MODIFY COLUMN status ENUM('idle', 'proses', 'selesai', 'menunggu', 'perbaikan_surat', 'sedang_diproses') NOT NULL DEFAULT 'idle'");

        // Step 4: Update data dari temp
        DB::statement("UPDATE pengajuan_surat SET status = 'menunggu' WHERE status_temp = 'idle'");
        DB::statement("UPDATE pengajuan_surat SET status = 'sedang_diproses' WHERE status_temp = 'proses'");
        // selesai tetap selesai

        // Step 5: Hapus kolom temp
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->dropColumn('status_temp');
        });

        // Step 6: Alter enum final (hapus nilai lama)
        DB::statement("ALTER TABLE pengajuan_surat MODIFY COLUMN status ENUM('menunggu', 'perbaikan_surat', 'sedang_diproses', 'selesai') NOT NULL DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: sedang_diproses -> proses, menunggu -> idle
        DB::table('pengajuan_surat')
            ->where('status', 'menunggu')
            ->update(['status' => 'idle']);

        DB::table('pengajuan_surat')
            ->where('status', 'sedang_diproses')
            ->update(['status' => 'proses']);

        DB::table('pengajuan_surat')
            ->where('status', 'perbaikan_surat')
            ->update(['status' => 'idle']);

        // Rollback enum
        DB::statement("ALTER TABLE pengajuan_surat MODIFY COLUMN status ENUM('idle', 'proses', 'selesai') NOT NULL DEFAULT 'idle'");
    }
};
