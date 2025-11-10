# Panduan Deploy ke Sevalla.com

## Troubleshooting Error Composer Install

### Penyebab Error:
1. ❌ Working directory tidak tepat
2. ❌ File `composer.json` tidak ditemukan
3. ❌ Platform requirements tidak terpenuhi
4. ❌ Memory limit terlalu kecil

### Solusi:

#### Opsi 1: Gunakan Dockerfile yang Sudah Diperbaiki

File `Dockerfile` di root sudah diperbaiki dengan:
- ✅ Copy `composer.json` dan `composer.lock` terlebih dahulu
- ✅ Install dependencies dengan flag yang tepat
- ✅ Better Docker layer caching
- ✅ Include Node.js untuk build assets

#### Opsi 2: Gunakan Dockerfile.sevalla

File `Dockerfile.sevalla` adalah versi yang lebih optimized dengan:
- ✅ All dependencies dalam satu layer
- ✅ `--ignore-platform-reqs` flag
- ✅ Better error handling
- ✅ Health check included

Untuk menggunakan:
```bash
# Rename atau copy
cp Dockerfile.sevalla Dockerfile
```

#### Opsi 3: Build Script

Jika Sevalla support build script, gunakan `build-sevalla.sh`:
```bash
chmod +x build-sevalla.sh
./build-sevalla.sh
```

## Langkah Deploy di Sevalla

### 1. Persiapan

```bash
# Pastikan file sudah OK
git add .
git commit -m "Fix Dockerfile for Sevalla"
git push origin main
```

### 2. Konfigurasi di Sevalla Dashboard

1. **Connect Repository**
   - Pilih GitHub repository
   - Branch: `main`

2. **Build Settings**
   - Build Command: `docker build -t app .`
   - Dockerfile Path: `./Dockerfile` atau `./Dockerfile.sevalla`

3. **Environment Variables**
   ```
   APP_NAME=SIDes-Surat
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:...  (generate dulu)
   APP_URL=https://your-app.sevalla.com
   
   DB_CONNECTION=mysql
   DB_HOST=<dari Sevalla database>
   DB_PORT=3306
   DB_DATABASE=<database name>
   DB_USERNAME=<database user>
   DB_PASSWORD=<database password>
   
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

4. **Database**
   - Buat MySQL database di Sevalla
   - Catat credentials
   - Tambahkan ke environment variables

### 3. Deploy

Klik "Deploy" dan tunggu proses build selesai.

## Auto-Deploy dan Update Aplikasi

### ✅ Auto-Deploy (REKOMENDASI)

Sevalla **SUPPORT auto-deploy** dari GitHub/GitLab! Cara mengaktifkan:

#### Setup Auto-Deploy:

1. **Di Sevalla Dashboard:**
   - Masuk ke Application Settings
   - Cari bagian **"Deployment"** atau **"Git Integration"**
   - Enable **"Auto Deploy"** atau **"Automatic Deployments"**
   - Pilih branch: `main` (atau branch yang Anda gunakan)

2. **Setelah Diaktifkan:**
   - Setiap kali Anda `git push origin main`
   - Sevalla akan **otomatis detect perubahan**
   - Build dan deploy ulang **secara otomatis**
   - Tidak perlu destroy & create ulang!

#### Workflow dengan Auto-Deploy:

```bash
# 1. Edit code di local
# 2. Commit & push
git add .
git commit -m "Update feature X"
git push origin main

# 3. Sevalla otomatis:
# - Detect push baru
# - Pull latest code
# - Build Docker image
# - Deploy container baru
# - Switch traffic ke container baru
# - Done! (5-10 menit)

# 4. Check status di Sevalla Dashboard
```

### 🔄 Manual Deploy

Jika auto-deploy belum aktif atau ingin deploy manual:

#### Opsi 1: Redeploy dari Dashboard

1. Login ke Sevalla Dashboard
2. Pilih application Anda
3. Klik **"Redeploy"** atau **"Deploy"** button
4. Tunggu build selesai
5. ✅ Done!

**TIDAK PERLU destroy & create ulang!**

#### Opsi 2: Deploy dengan Webhook

Jika Sevalla provide webhook URL:

1. Copy webhook URL dari Sevalla Dashboard
2. Add ke GitHub repository:
   - Settings → Webhooks → Add webhook
   - Paste URL
   - Events: Push events
   - Save
3. Setiap push akan trigger deploy

#### Opsi 3: Via CLI (jika tersedia)

```bash
# Install Sevalla CLI (jika ada)
sevalla login

# Deploy manual
sevalla deploy --app sides-surat
```

### ❌ Yang TIDAK PERLU Dilakukan:

- ❌ **Jangan destroy & create ulang** - ini akan hapus database dan settings!
- ❌ **Jangan delete application** - cukup redeploy
- ❌ **Jangan create new app** untuk setiap update

### 🎯 Best Practice Update:

1. **Development:**
   ```bash
   # Test di local dulu
   composer install
   npm run build
   php artisan serve
   ```

2. **Commit & Push:**
   ```bash
   git add .
   git commit -m "Descriptive message"
   git push origin main
   ```

3. **Monitor Deploy:**
   - Buka Sevalla Dashboard
   - Lihat Deployment Logs
   - Tunggu status "Running" atau "Active"
   - Test aplikasi

4. **Rollback (jika ada error):**
   - Di Sevalla Dashboard
   - Cari "Deployments" atau "History"
   - Pilih deployment sebelumnya yang sukses
   - Klik "Rollback" atau "Redeploy"

### 📊 Deploy Timeline:

| Action | Time | Auto-Deploy |
|--------|------|-------------|
| git push | 1s | ✅ Triggers |
| Detect push | 5-30s | ✅ Auto |
| Build image | 5-10 min | ✅ Auto |
| Deploy | 1-2 min | ✅ Auto |
| **Total** | **~10 min** | ✅ Zero touch |

### 🔔 Notifications:

Setup notifikasi agar tahu kapan deploy selesai:
- Email notification
- Slack/Discord webhook
- Check Sevalla settings untuk integration

### 🐛 Jika Auto-Deploy Tidak Berfungsi:

1. **Check Connection:**
   - Sevalla → Settings → Git Integration
   - Ensure GitHub/GitLab connected
   - Check permissions

2. **Check Webhook:**
   - GitHub → Settings → Webhooks
   - Look for Sevalla webhook
   - Check recent deliveries for errors

3. **Manual Trigger:**
   - Sevalla Dashboard → Redeploy button
   - Force rebuild

4. **Contact Support:**
   - Sevalla support team
   - Provide error logs

## Debugging Tips

### Jika Build Masih Gagal:

1. **Check Logs Lengkap**
   - Lihat full build logs di Sevalla dashboard
   - Cari error specific

2. **Test Build Locally**
   ```bash
   # Test build Docker image
   docker build -t sides-surat .
   
   # Jika error, coba dengan verbose
   docker build --progress=plain -t sides-surat .
   ```

3. **Check composer.json**
   ```bash
   # Validate composer.json
   composer validate
   
   # Check platform requirements
   composer check-platform-reqs
   ```

4. **Simplify Dockerfile**
   - Remove optional dependencies
   - Use `--ignore-platform-reqs`
   - Skip development packages

## Alternative: Dockerfile Minimal

Jika masih error, coba Dockerfile minimal ini:

```dockerfile
FROM php:8.2-apache

WORKDIR /var/www/html

# Minimal dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip \
    && apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache modules
RUN a2enmod rewrite

# Copy files
COPY . .

# Install dependencies
RUN composer install --no-dev --no-interaction --ignore-platform-reqs

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
```

## Common Issues

### Issue 1: Composer Memory Error
**Solution:** Add to composer install:
```dockerfile
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev
```

### Issue 2: Node/NPM Error
**Solution:** Install Node.js properly:
```dockerfile
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
```

### Issue 3: Permission Denied
**Solution:** Ensure directories exist:
```dockerfile
RUN mkdir -p storage/logs storage/framework/cache \
    && chmod -R 775 storage bootstrap/cache
```

## Check Requirements

Pastikan `composer.json` tidak ada requirements yang terlalu strict:

```json
{
    "require": {
        "php": "^8.2",  // OK
        "ext-pdo": "*"   // OK
    }
}
```

## Contact Support

Jika masih error:
1. Screenshot full error log
2. Share ke Sevalla support
3. Atau coba platform lain (Railway, Vercel, dll)

## Alternative Platforms (Gratis untuk Pelajar)

Jika Sevalla tidak work:
1. **Railway.app** - $5 credit gratis/bulan
2. **Vercel** - Gratis untuk hobby project
3. **Fly.io** - Free tier tersedia
4. **GitHub Student Pack** - Banyak kredit gratis

---

## 📝 Summary: Update Workflow

### Dengan Auto-Deploy (Mudah!):
```bash
# Local changes
git add .
git commit -m "Update"
git push origin main

# Sevalla auto-deploy ✅
# Wait ~10 minutes
# Done! 🎉
```

### Manual Deploy (Jika diperlukan):
1. Push ke GitHub: `git push origin main`
2. Sevalla Dashboard → **Redeploy button**
3. Wait ~10 minutes
4. Done! 🎉

### ⚠️ PENTING:
- ✅ **Redeploy** untuk update (keep database & settings)
- ❌ **JANGAN destroy** untuk update (akan hapus semua!)

---

**Pro Tip:** Selalu test Docker build locally dulu sebelum push!

```bash
docker build -t test-app .
docker run -p 8080:80 test-app
```

## 🎓 Learning Resources

- Sevalla Documentation: https://sevalla.com/docs
- Docker Best Practices: https://docs.docker.com/develop/dev-best-practices/
- Laravel Deployment: https://laravel.com/docs/deployment

## 🆘 Need Help?

1. Check Sevalla Dashboard Logs
2. Read error messages carefully
3. Search Sevalla documentation
4. Contact Sevalla support
5. Ask in Laravel community
