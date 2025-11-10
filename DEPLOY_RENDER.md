# Deploy ke Render.com

Panduan lengkap untuk deploy aplikasi SIDes-Surat ke Render.com.

## Prerequisites

1. Akun Render.com (gratis)
2. Repository GitHub/GitLab (push kode Anda ke repository)
3. Database MySQL di Render (akan dibuat otomatis dengan render.yaml)

## Cara Deploy

### Metode 1: Menggunakan render.yaml (Rekomendasi)

1. **Push kode ke GitHub/GitLab**
   ```bash
   git add .
   git commit -m "Add Render configuration"
   git push origin main
   ```

2. **Buat New Blueprint di Render**
   - Login ke [Render Dashboard](https://dashboard.render.com/)
   - Klik "New +" → "Blueprint"
   - Connect repository GitHub/GitLab Anda
   - Render akan otomatis mendeteksi `render.yaml`
   - Klik "Apply"

3. **Tunggu deployment selesai**
   - Render akan membuat database MySQL dan web service secara otomatis
   - Proses ini memakan waktu 5-10 menit

4. **Set environment variables tambahan**
   - Setelah service dibuat, masuk ke service settings
   - Tambahkan `APP_URL` dengan URL dari Render (contoh: https://sides-surat.onrender.com)

### Metode 2: Manual Setup

#### A. Buat Database MySQL

1. Di Render Dashboard, klik "New +" → "MySQL"
2. Isi detail:
   - **Name**: sides-surat-db
   - **Database**: sides_surat
   - **User**: sides_user
   - **Region**: Singapore (lebih dekat ke Indonesia)
   - **Plan**: Free
3. Klik "Create Database"
4. Simpan kredensial database yang diberikan

#### B. Buat Web Service

1. Klik "New +" → "Web Service"
2. Connect repository Anda
3. Isi detail:
   - **Name**: sides-surat
   - **Region**: Singapore
   - **Branch**: main (atau branch yang Anda gunakan)
   - **Runtime**: Docker
   - **Dockerfile Path**: Dockerfile.render
   - **Plan**: Free

4. **Tambahkan Environment Variables:**
   ```
   APP_NAME=SIDes-Surat
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://sides-surat.onrender.com (ganti dengan URL Anda)
   APP_KEY=base64:... (akan di-generate otomatis)
   
   DB_CONNECTION=mysql
   DB_HOST=<dari database yang dibuat>
   DB_PORT=<dari database yang dibuat>
   DB_DATABASE=sides_surat
   DB_USERNAME=sides_user
   DB_PASSWORD=<dari database yang dibuat>
   
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   FILESYSTEM_DISK=local
   
   LOG_CHANNEL=stack
   LOG_LEVEL=error
   ```

5. Klik "Create Web Service"

## Setelah Deploy

### 1. Generate Application Key (jika belum)

Jika APP_KEY belum di-set, buka Shell di Render Dashboard:
```bash
php artisan key:generate --show
```
Copy hasilnya dan tambahkan ke Environment Variables.

### 2. Jalankan Migration & Seeder (opsional)

Buka Shell di Render Dashboard dan jalankan:
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 3. Setup Storage Link (jika menggunakan file upload)

```bash
php artisan storage:link
```

### 4. Test Aplikasi

Buka URL yang diberikan Render (contoh: https://sides-surat.onrender.com)

## Troubleshooting

### Build Failed

1. Check logs di Render Dashboard
2. Pastikan `Dockerfile.render` dan `docker/entrypoint.sh` ada di repository
3. Pastikan semua dependencies di `composer.json` dan `package.json` benar

### Database Connection Error

1. Pastikan database sudah running
2. Verifikasi environment variables DB_* sudah benar
3. Cek apakah IP Render sudah di-allowlist (untuk free tier, ini otomatis)

### 500 Error

1. Set `APP_DEBUG=true` sementara untuk melihat error
2. Check logs: Render Dashboard → Service → Logs
3. Pastikan migrations sudah dijalankan
4. Pastikan APP_KEY sudah di-generate

### Aplikasi Lambat (Free Tier)

- Free tier akan sleep setelah 15 menit tidak ada traffic
- Akses pertama setelah sleep akan lambat (30-60 detik)
- Untuk production, gunakan paid tier

## Custom Domain (Opsional)

1. Di service settings, klik "Add Custom Domain"
2. Ikuti instruksi untuk setup DNS
3. Update `APP_URL` di environment variables

## Update Aplikasi

1. Push perubahan ke repository:
   ```bash
   git add .
   git commit -m "Update aplikasi"
   git push origin main
   ```

2. Render akan otomatis deploy ulang

## Monitoring

- **Logs**: Render Dashboard → Service → Logs
- **Metrics**: Render Dashboard → Service → Metrics
- **Events**: Render Dashboard → Service → Events

## Backup Database

1. Di Render Dashboard, masuk ke database
2. Klik "Backups" untuk mengatur automatic backups
3. Free tier: manual backup via mysqldump di Shell

## Biaya

- **Free Tier**: 
  - 750 jam compute/bulan (cukup untuk 1 service 24/7)
  - Database MySQL 1GB
  - Sleep setelah 15 menit inaktif
  - Build time 500 menit/bulan

- **Starter Tier** ($7/bulan):
  - Tidak ada sleep
  - Lebih banyak resources

## Tips Performance

1. Gunakan caching:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. Optimize composer:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. Minify assets dengan Vite (sudah di-setup)

## Support

Jika ada masalah:
1. Check Render [documentation](https://render.com/docs)
2. Check Render [status page](https://status.render.com/)
3. Contact Render support via dashboard

## File Penting untuk Render

- `render.yaml` - Blueprint configuration
- `Dockerfile.render` - Docker configuration untuk Render
- `docker/entrypoint.sh` - Script yang dijalankan saat container start
- `.dockerignore` - File yang diabaikan saat build Docker image
