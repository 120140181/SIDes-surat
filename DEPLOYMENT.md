# 🚀 Deployment Guide - SIDes Surat

## ⚡ QUICK FIX - Tanpa Terminal/SSH

**Jika terminal Sevalla tidak bisa diakses:**

### Gunakan Setup Web Utility

1. **Upload file `setup.php`**
   - File ada di: `public/setup.php`
   - Upload via FTP/File Manager Sevalla ke folder `public/`

2. **Akses via browser:**
   ```
   https://domain-anda.sevalla.app/setup.php
   ```

3. **Login dengan password:**
   ```
   Password default: sides2025
   ```
   *(Edit file setup.php untuk ganti password)*

4. **Klik: "⚡ Jalankan Semua"**
   - Auto create folders
   - Auto create symlink
   - Auto fix permissions
   - Auto clear cache

5. **✅ Test upload dokumen baru**

6. **🔒 HAPUS `setup.php` setelah selesai!**
   ```
   Hapus via File Manager: public/setup.php
   ```

---

## Deployment ke Production (Sevalla)

### 1️⃣ Update Code dari GitHub

```bash
cd /var/www/html
git pull origin main
```

### 2️⃣ Jalankan Deployment Script

```bash
chmod +x deploy.sh
./deploy.sh
```

**Atau manual:**

```bash
# Create folders
mkdir -p storage/app/public/dokumen_pengajuan
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create symlink
php artisan storage:link

# Clear cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3️⃣ Cek Storage Link

Pastikan symlink berhasil dibuat:

```bash
ls -la public/storage
```

Output seharusnya:
```
lrwxrwxrwx ... public/storage -> ../../storage/app/public
```

### 4️⃣ Cek Folder Dokumen

```bash
ls -la storage/app/public/
```

Seharusnya ada folder `dokumen_pengajuan/`

---

## ⚠️ Troubleshooting

### Error 404 saat akses file

**Penyebab:**
- Symlink `public/storage` belum dibuat
- Folder `storage/app/public/dokumen_pengajuan/` tidak ada
- File upload belum ada (karena tidak di-push ke git)

**Solusi:**

1. **Buat symlink:**
   ```bash
   php artisan storage:link
   ```

2. **Buat folder:**
   ```bash
   mkdir -p storage/app/public/dokumen_pengajuan
   chmod -R 775 storage/app/public
   ```

3. **Test upload baru:**
   - Login sebagai warga di production
   - Buat pengajuan baru dengan upload dokumen
   - Cek apakah file masuk ke `storage/app/public/dokumen_pengajuan/`

### Symlink sudah ada tapi masih 404

**Cek apakah symlink valid:**

```bash
ls -la public/storage
readlink -f public/storage
```

**Hapus dan buat ulang:**

```bash
rm public/storage
php artisan storage:link
```

### Permission denied

```bash
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📝 Catatan Penting

1. **File upload TIDAK di-push ke Git** (ada di `.gitignore`)
2. **Data lokal tidak akan ada di production** - perlu upload ulang
3. **Setelah deployment, test dengan upload dokumen baru**
4. **Jangan copy file manual** - biarkan user upload via form

---

## ✅ Checklist Deployment

- [ ] Git pull berhasil
- [ ] Deploy script dijalankan
- [ ] Storage symlink dibuat (`ls -la public/storage`)
- [ ] Folder dokumen_pengajuan ada (`ls -la storage/app/public/`)
- [ ] Cache cleared
- [ ] Test upload dokumen baru
- [ ] Test lihat & download dokumen
- [ ] Check error log: `tail -f storage/logs/laravel.log`

---

## 🔄 Update Rutin

Setiap kali update code:

```bash
git pull origin main
./deploy.sh
```

Atau manual:

```bash
git pull origin main
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🆘 Emergency Rollback

Jika ada masalah setelah deployment:

```bash
# Lihat commit sebelumnya
git log --oneline -5

# Rollback ke commit tertentu
git reset --hard COMMIT_HASH

# Clear cache
php artisan optimize:clear
```

---

**Dokumentasi dibuat:** November 25, 2025
**Sistem:** SIDes-Surat v1.0
**Stack:** Laravel 12, PHP 8.2, MySQL 8.0
