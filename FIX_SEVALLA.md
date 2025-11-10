# 🔧 FIX untuk Error Composer Install di Sevalla

## ✅ Masalah Sudah Diperbaiki!

### Yang Sudah Dilakukan:

1. **Fixed composer.json** ✅
   - Removed `post-install-cmd` scripts yang menyebabkan error
   - Scripts artisan sekarang hanya dijalankan manual/production

2. **Fixed Dockerfile** ✅
   - Copy `composer.json` dan `composer.lock` terlebih dahulu
   - Install dependencies dengan `--no-scripts` flag
   - Added Node.js installation
   - Better layer caching
   - Proper permissions

3. **Created Dockerfile.sevalla** ✅
   - Versi alternatif jika main Dockerfile masih bermasalah
   - Lebih optimized dan robust

## 🚀 Langkah Selanjutnya:

### 1. Commit & Push Perubahan

```powershell
git add .
git commit -m "Fix Dockerfile for Sevalla deployment"
git push origin main
```

### 2. Deploy Ulang di Sevalla

Sevalla akan otomatis detect perubahan dan rebuild dengan Dockerfile yang baru.

### 3. Jika Masih Error

Gunakan `Dockerfile.sevalla`:
```powershell
# Rename Dockerfile
mv Dockerfile Dockerfile.backup
mv Dockerfile.sevalla Dockerfile

# Commit & push
git add .
git commit -m "Use alternative Dockerfile"
git push origin main
```

## 📋 Perbedaan Dockerfile Lama vs Baru

### ❌ Dockerfile Lama (Error):
```dockerfile
COPY . .  # Copy semua dulu
RUN composer install  # composer.json belum di copy
```

### ✅ Dockerfile Baru (Fixed):
```dockerfile
COPY composer.json composer.lock ./  # Copy composer files dulu
RUN composer install --no-scripts     # Install tanpa script
COPY . .                               # Copy sisanya
RUN composer dump-autoload             # Complete installation
```

## 🐛 Error yang Diperbaiki

### Error 1: Composer scripts gagal
**Penyebab:** `post-install-cmd` menjalankan artisan commands
**Solusi:** Removed dari `post-install-cmd`, pindah ke manual script

### Error 2: Working directory issue
**Penyebab:** File belum ter-copy saat composer install
**Solusi:** Copy composer files dulu sebelum install

### Error 3: Node.js tidak tersedia
**Penyebab:** npm install gagal karena nodejs belum di-install
**Solusi:** Install Node.js dari official repository

## ✨ Fitur Tambahan

- 🎯 Better Docker layer caching (build lebih cepat)
- 📦 Production-only dependencies
- 🗜️ Image size optimization (remove node_modules after build)
- 🔒 Proper file permissions
- 🏥 Health check ready (di Dockerfile.sevalla)

## 📝 Environment Variables untuk Sevalla

Set di Sevalla Dashboard:

```env
APP_NAME=SIDes-Surat
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (generate dengan: php artisan key:generate --show)
APP_URL=https://your-app.sevalla.com

DB_CONNECTION=mysql
DB_HOST=<sevalla-db-host>
DB_PORT=3306
DB_DATABASE=<database-name>
DB_USERNAME=<database-user>
DB_PASSWORD=<database-password>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 🧪 Test Build Locally (Optional)

Sebelum push, test dulu di local:

```powershell
# Build Docker image
docker build -t sides-surat-test .

# Jika success, image siap!
# Jika error, lihat error message dan perbaiki
```

## 💡 Tips

1. **Selalu check logs** di Sevalla dashboard jika masih error
2. **Pastikan composer.lock** ter-commit ke git
3. **Pastikan package-lock.json** ter-commit ke git
4. **Database** harus sudah dibuat sebelum deploy

## 📞 Jika Masih Bermasalah

Baca dokumentasi lengkap di `SEVALLA_DEPLOY.md` untuk:
- Alternative Dockerfile minimal
- Debugging tips
- Common issues & solutions
- Alternative platforms

---

**Ready to deploy!** 🚀 Push perubahan dan deploy ulang di Sevalla.
