<?php
// database/migrations/[...]_add_profile_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Semua field dibuat nullable kecuali kewarganegaraan
            $table->string('alamat')->after('jenis_kelamin')->nullable();
            $table->string('agama')->after('alamat')->nullable();
            $table->string('pekerjaan')->after('agama')->nullable();
            $table->string('status_perkawinan')->after('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->after('status_perkawinan')->default('Indonesia');
            $table->string('no_telepon')->after('kewarganegaraan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'alamat',
                'agama',
                'pekerjaan',
                'status_perkawinan',
                'kewarganegaraan',
                'no_telepon'
            ]);
        });
    }
};
