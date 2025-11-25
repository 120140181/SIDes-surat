<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CleanDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:clean-dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus semua data dummy warga dan pengajuan surat (kecuali admin)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('⚠️  PERINGATAN: Ini akan menghapus SEMUA data warga dan pengajuan surat! Lanjutkan?')) {
            $this->info('Operasi dibatalkan.');
            return 0;
        }

        $this->info('🗑️  Mulai membersihkan data dummy...');
        $this->newLine();

        // 1. Hapus semua pengajuan surat (akan trigger auto-delete files via model event)
        $this->info('📄 Menghapus pengajuan surat...');
        $pengajuanCount = PengajuanSurat::count();

        if ($pengajuanCount > 0) {
            $bar = $this->output->createProgressBar($pengajuanCount);
            $bar->start();

            PengajuanSurat::chunk(50, function($pengajuans) use ($bar) {
                foreach ($pengajuans as $pengajuan) {
                    $pengajuan->delete(); // Trigger model event untuk hapus files
                    $bar->advance();
                }
            });

            $bar->finish();
            $this->newLine();
            $this->info("✅ {$pengajuanCount} pengajuan surat dihapus");
        } else {
            $this->warn('Tidak ada pengajuan surat');
        }

        $this->newLine();

        // 2. Hapus semua user dengan role warga
        $this->info('👥 Menghapus data warga...');
        $wargaCount = User::where('role', 'warga')->count();

        if ($wargaCount > 0) {
            User::where('role', 'warga')->delete();
            $this->info("✅ {$wargaCount} data warga dihapus");
        } else {
            $this->warn('Tidak ada data warga');
        }

        $this->newLine();

        // 3. Bersihkan folder storage (opsional - hanya jika ada file orphan)
        $this->info('🧹 Membersihkan file storage...');
        $dokumenPath = 'dokumen_pengajuan';

        if (Storage::disk('public')->exists($dokumenPath)) {
            $files = Storage::disk('public')->files($dokumenPath);
            $fileCount = count($files);

            if ($fileCount > 0) {
                foreach ($files as $file) {
                    Storage::disk('public')->delete($file);
                }
                $this->info("✅ {$fileCount} file dihapus dari storage");
            } else {
                $this->info('Tidak ada file di storage');
            }
        }

        $this->newLine();

        // 4. Reset auto increment (opsional)
        if ($this->confirm('Reset auto increment ID ke 1?', true)) {
            DB::statement('ALTER TABLE pengajuan_surat AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
            $this->info('✅ Auto increment direset');
        }

        $this->newLine();
        $this->info('🎉 Selesai! Database sudah bersih.');
        $this->newLine();

        // Summary
        $this->table(
            ['Tabel', 'Status'],
            [
                ['Pengajuan Surat', '✓ Dihapus'],
                ['Data Warga', '✓ Dihapus'],
                ['Storage Files', '✓ Dibersihkan'],
                ['Admin User', '✓ Tetap Ada'],
            ]
        );

        return 0;
    }
}
