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

**Pro Tip:** Selalu test Docker build locally dulu sebelum push!

```bash
docker build -t test-app .
docker run -p 8080:80 test-app
```
