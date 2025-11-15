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
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom email untuk admin login (nullable untuk warga yang sudah ada)
            $table->string('email')->nullable()->after('nik');

            // Update admin yang sudah ada dengan email default
            // Bisa diubah nanti via database
        });

        // Set email untuk admin yang sudah ada
        DB::table('users')
            ->where('role', 'admin')
            ->update(['email' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
