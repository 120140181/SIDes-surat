<?php
/**
 * SIDes-Surat Setup Utility
 * Akses via: https://domain.com/setup.php
 *
 * PENTING: Hapus file ini setelah setup selesai!
 */

// Password untuk akses (ubah ini!)
define('SETUP_PASSWORD', 'sides2025');

// Cek password
$isAuthorized = false;
if (isset($_POST['password']) && $_POST['password'] === SETUP_PASSWORD) {
    $isAuthorized = true;
    $_SESSION['setup_auth'] = true;
}
if (isset($_SESSION['setup_auth'])) {
    $isAuthorized = true;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDes-Surat Setup</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            padding: 40px;
        }
        h1 {
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .subtitle {
            color: #718096;
            margin-bottom: 30px;
        }
        .action-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px 10px 10px 0;
            transition: all 0.3s ease;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        .action-btn.danger {
            background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
        }
        .result {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            white-space: pre-wrap;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-height: 400px;
            overflow-y: auto;
        }
        .success { border-left-color: #48bb78; background: #f0fff4; }
        .error { border-left-color: #f56565; background: #fff5f5; }
        .warning { border-left-color: #ed8936; background: #fffaf0; }
        .login-form {
            text-align: center;
        }
        .login-form input {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 15px;
        }
        .status-box {
            background: #edf2f7;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .status-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
        }
        .status-ok { color: #48bb78; }
        .status-fail { color: #f56565; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 SIDes-Surat Setup</h1>
        <p class="subtitle">Utility untuk setup storage dan permissions</p>

        <?php if (!$isAuthorized): ?>
            <div class="login-form">
                <form method="POST">
                    <input type="password" name="password" placeholder="Masukkan password setup" required autofocus>
                    <br>
                    <button type="submit" class="action-btn">Login</button>
                </form>
                <div class="result warning" style="margin-top: 20px;">
                    <strong>⚠️ Akses Terbatas</strong><br>
                    Password default: <code>sides2025</code><br>
                    Edit file ini untuk mengubah password.
                </div>
            </div>
        <?php else: ?>

            <h3>📋 Status Sistem</h3>
            <div class="status-box">
                <?php
                $checks = [
                    'Storage Folder' => is_dir('../storage/app/public'),
                    'Dokumen Folder' => is_dir('../storage/app/public/dokumen_pengajuan'),
                    'Storage Writable' => is_writable('../storage/app/public'),
                    'Storage Symlink' => is_link('storage') || is_dir('storage'),
                ];

                foreach ($checks as $label => $status) {
                    $icon = $status ? '✅' : '❌';
                    $class = $status ? 'status-ok' : 'status-fail';
                    echo "<div class='status-item'><span class='$class'>$icon</span> <strong>$label:</strong> " . ($status ? 'OK' : 'GAGAL') . "</div>";
                }
                ?>
            </div>

            <h3 style="margin-top: 30px;">🛠️ Actions</h3>

            <form method="POST" style="margin: 20px 0;">
                <input type="hidden" name="password" value="<?= SETUP_PASSWORD ?>">
                <button type="submit" name="action" value="create_folders" class="action-btn">
                    📁 Buat Folder Storage
                </button>
                <button type="submit" name="action" value="create_symlink" class="action-btn">
                    🔗 Buat Storage Symlink
                </button>
                <button type="submit" name="action" value="fix_permissions" class="action-btn">
                    🔐 Fix Permissions
                </button>
                <button type="submit" name="action" value="clear_cache" class="action-btn">
                    🧹 Clear Cache
                </button>
                <button type="submit" name="action" value="run_all" class="action-btn">
                    ⚡ Jalankan Semua
                </button>
            </form>

            <?php
            if (isset($_POST['action'])) {
                $action = $_POST['action'];
                $output = [];

                switch ($action) {
                    case 'create_folders':
                        $output[] = "📁 Membuat folder storage...";
                        $folders = [
                            '../storage/app/public',
                            '../storage/app/public/dokumen_pengajuan',
                            '../storage/framework/cache',
                            '../storage/framework/sessions',
                            '../storage/framework/views',
                            '../storage/logs'
                        ];
                        foreach ($folders as $folder) {
                            if (!is_dir($folder)) {
                                if (mkdir($folder, 0775, true)) {
                                    $output[] = "✅ Berhasil: " . basename($folder);
                                } else {
                                    $output[] = "❌ Gagal: " . basename($folder);
                                }
                            } else {
                                $output[] = "ℹ️  Sudah ada: " . basename($folder);
                            }
                        }
                        break;

                    case 'create_symlink':
                        $output[] = "🔗 Membuat storage symlink...";
                        $target = '../storage/app/public';
                        $link = 'storage';

                        if (is_link($link)) {
                            unlink($link);
                            $output[] = "ℹ️  Symlink lama dihapus";
                        }

                        if (symlink($target, $link)) {
                            $output[] = "✅ Symlink berhasil dibuat!";
                            $output[] = "   public/storage -> storage/app/public";
                        } else {
                            $output[] = "❌ Gagal membuat symlink";
                            $output[] = "   Alternatif: Jalankan 'php artisan storage:link' via SSH";
                        }
                        break;

                    case 'fix_permissions':
                        $output[] = "🔐 Memperbaiki permissions...";
                        $paths = [
                            '../storage' => 0775,
                            '../storage/app' => 0775,
                            '../storage/app/public' => 0775,
                            '../storage/app/public/dokumen_pengajuan' => 0775,
                            '../storage/framework' => 0775,
                            '../storage/logs' => 0775,
                            '../bootstrap/cache' => 0775
                        ];

                        foreach ($paths as $path => $perm) {
                            if (is_dir($path)) {
                                if (chmod($path, $perm)) {
                                    $output[] = "✅ " . basename($path) . " -> 0775";
                                } else {
                                    $output[] = "❌ Gagal: " . basename($path);
                                }
                            }
                        }
                        break;

                    case 'clear_cache':
                        $output[] = "🧹 Membersihkan cache...";
                        $cacheFiles = [
                            '../bootstrap/cache/config.php',
                            '../bootstrap/cache/routes-v7.php',
                            '../bootstrap/cache/services.php',
                        ];

                        foreach ($cacheFiles as $file) {
                            if (file_exists($file)) {
                                if (unlink($file)) {
                                    $output[] = "✅ Dihapus: " . basename($file);
                                }
                            }
                        }

                        // Clear view cache
                        $viewPath = '../storage/framework/views';
                        if (is_dir($viewPath)) {
                            $files = glob($viewPath . '/*');
                            foreach ($files as $file) {
                                if (is_file($file)) {
                                    unlink($file);
                                }
                            }
                            $output[] = "✅ View cache cleared";
                        }
                        break;

                    case 'run_all':
                        $output[] = "⚡ Menjalankan semua setup...";
                        $output[] = "";

                        // Create folders
                        $output[] = "1️⃣ Membuat folder...";
                        $folders = [
                            '../storage/app/public/dokumen_pengajuan',
                            '../storage/framework/cache',
                            '../storage/framework/sessions',
                            '../storage/framework/views',
                        ];
                        foreach ($folders as $folder) {
                            if (!is_dir($folder)) {
                                mkdir($folder, 0775, true);
                            }
                        }
                        $output[] = "✅ Folder dibuat";
                        $output[] = "";

                        // Create symlink
                        $output[] = "2️⃣ Membuat symlink...";
                        $target = '../storage/app/public';
                        $link = 'storage';
                        if (is_link($link)) unlink($link);
                        symlink($target, $link);
                        $output[] = "✅ Symlink dibuat";
                        $output[] = "";

                        // Fix permissions
                        $output[] = "3️⃣ Memperbaiki permissions...";
                        chmod('../storage/app/public', 0775);
                        chmod('../storage/app/public/dokumen_pengajuan', 0775);
                        $output[] = "✅ Permissions diperbaiki";
                        $output[] = "";

                        $output[] = "🎉 Setup selesai!";
                        $output[] = "";
                        $output[] = "📝 Langkah selanjutnya:";
                        $output[] = "1. Test upload dokumen baru via form pengajuan";
                        $output[] = "2. Hapus file setup.php ini untuk keamanan";
                        break;
                }

                $resultClass = strpos(implode(' ', $output), '❌') !== false ? 'error' : 'success';
                echo "<div class='result $resultClass'>" . implode("\n", $output) . "</div>";
            }
            ?>

            <div class="result warning" style="margin-top: 30px;">
                <strong>⚠️ PENTING - Keamanan</strong><br><br>
                Setelah setup selesai, HAPUS file ini dengan cara:<br>
                <code>rm public/setup.php</code><br><br>
                File ini bisa diakses siapa saja dan berbahaya jika dibiarkan!
            </div>

        <?php endif; ?>
    </div>
</body>
</html>
