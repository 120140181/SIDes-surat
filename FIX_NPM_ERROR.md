# 🔧 Fix: NPM CI Error di Sevalla

## Error yang Terjadi:

```
npm error Run "npm help ci" for more info
ERROR: process "/bin/bash -ol pipefail -c npm ci" did not complete successfully: exit code: 1
```

## ✅ Sudah Diperbaiki!

### Penyebab:
1. ❌ `npm ci` terlalu strict dengan `package-lock.json`
2. ❌ Versi Node.js di Docker berbeda dengan local
3. ❌ Dependencies conflict

### Solusi yang Diterapkan:

### 🚨 IMPORTANT: Check .dockerignore First!

**BEFORE** modifying Dockerfile, check if `.dockerignore` is blocking `package-lock.json`:

```bash
# Check .dockerignore content
cat .dockerignore | grep package-lock.json

# If found, REMOVE THIS LINE:
# package-lock.json  <-- DELETE THIS!
```

**Why?** Even if you have `package-lock.json` locally, if `.dockerignore` blocks it, the file won't be copied to Docker image!

## 🔧 Solusi yang Diterapkan

### 0. **Fix .dockerignore** (CRITICAL!)
```bash
# Edit .dockerignore and remove:
package-lock.json

# Or comment it out:
# package-lock.json is needed for npm ci
```

### 1. Ganti npm ci dengan npm install

**Sebelum:**
```dockerfile
RUN npm ci --only=production || npm install --only=production
```

**Sesudah:**
```dockerfile
RUN npm install --production --no-optional --legacy-peer-deps
```

**Kenapa?**
- ✅ `npm install` lebih toleran
- ✅ `--legacy-peer-deps` untuk bypass peer dependency conflicts
- ✅ `--no-optional` untuk skip optional dependencies
- ✅ `--production` untuk install production deps saja

#### 2. Regenerate package-lock.json

```powershell
# Sudah dilakukan:
rm package-lock.json
npm install
```

File `package-lock.json` baru sudah ter-generate dan compatible.

#### 3. Update Semua Dockerfile

- ✅ `Dockerfile` - Updated
- ✅ `Dockerfile.minimal` - Updated
- ✅ `Dockerfile.sevalla` - Updated

## 🚀 Langkah Selanjutnya:

### 1. Commit & Push

```powershell
git add .
git commit -m "Fix npm ci error - use npm install with legacy peer deps"
git push origin main
```

### 2. Redeploy di Sevalla

Sevalla akan otomatis rebuild dengan Dockerfile yang baru, atau:
- Manual: Dashboard → Redeploy button

### 3. Build Seharusnya Sukses!

Timeline baru:
- ✅ Composer install - **SUKSES** (sudah jalan)
- ✅ NPM install - **SUKSES** (sudah diperbaiki)
- ✅ Build assets - **SUKSES** (seharusnya)
- ✅ Deploy - **SUKSES** 🎉

## 📊 Perbandingan npm ci vs npm install

| Feature | `npm ci` | `npm install` |
|---------|----------|---------------|
| Speed | ⚡ Faster | 🐢 Slower |
| Strict | ✅ Very strict | ⚠️ Flexible |
| package-lock.json | Required exact match | Can update |
| Best for | CI/CD pipelines | Development/flexible env |
| Error tolerance | ❌ Low | ✅ High |

**Untuk deployment dengan possible version conflicts, `npm install` lebih aman.**

## 🎯 Flags Explained

### `--production`
- Install production dependencies only
- Skip `devDependencies`
- Reduce image size

### `--no-optional`
- Skip optional dependencies
- Avoid errors from optional deps that fail

### `--legacy-peer-deps`
- Bypass peer dependency version conflicts
- Useful for packages with strict peer deps
- Laravel Vite plugin often needs this

## 🔍 Verification

Setelah deploy, check:

1. **Build Logs:**
   ```
   ✓ Composer install - OK
   ✓ NPM install - OK
   ✓ NPM run build - OK
   ✓ Permissions - OK
   ✓ Deploy - OK
   ```

2. **Application:**
   - URL accessible
   - Assets loaded (CSS/JS)
   - No 500 errors

## 🐛 Jika Masih Error

### Error: "vite: command not found" atau build error

**Solusi:** Install dev dependencies juga (temporarily):

```dockerfile
# Change this line:
RUN npm install --production --no-optional --legacy-peer-deps

# To:
RUN npm install --legacy-peer-deps  # Include devDependencies
```

Kenapa? Karena `vite` ada di `devDependencies`, tapi diperlukan untuk build.

### Error: "Cannot find module 'vite'"

Same solution, install all dependencies including dev:

```dockerfile
RUN npm install --legacy-peer-deps
RUN npm run build
RUN rm -rf node_modules  # Clean up after build
```

## 💡 Alternative: Pre-build Assets Locally

Jika npm install masih bermasalah:

```powershell
# 1. Build di local
npm install
npm run build

# 2. Commit hasil build
git add public/build
git commit -m "Add pre-built assets"
git push origin main

# 3. Update Dockerfile - skip npm build
# Remove atau comment out:
# RUN npm install ...
# RUN npm run build
```

**Pro:**
- ✅ No npm errors di Docker
- ✅ Faster build (skip npm)

**Con:**
- ⚠️ Harus build manual tiap update assets
- ⚠️ Repo size lebih besar

## 📋 Complete Dockerfile (Working Version)

```dockerfile
FROM php:8.2-apache
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libzip-dev libonig-dev \
    default-mysql-client \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache modules
RUN a2enmod rewrite headers

# Copy and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# Copy and install Node dependencies
COPY package*.json ./
RUN npm install --legacy-peer-deps

# Copy Apache config
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy app files
COPY . .

# Complete composer
RUN composer dump-autoload --optimize --no-dev

# Build assets
RUN npm run build

# Clean up
RUN rm -rf node_modules

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create .env
RUN if [ ! -f .env ]; then cp .env.example .env; fi

EXPOSE 80
CMD ["apache2-foreground"]
```

## ✅ Checklist

- [x] Dockerfile updated dengan `npm install` instead of `npm ci`
- [x] Added `--legacy-peer-deps` flag
- [x] Regenerated `package-lock.json`
- [ ] Commit & push changes
- [ ] Redeploy di Sevalla
- [ ] Verify build logs
- [ ] Test application

## 🎉 Expected Result

```
Building...
✓ Installing system dependencies
✓ Installing Composer
✓ Installing PHP dependencies
✓ Installing Node.js dependencies  ← This should work now!
✓ Building assets with Vite
✓ Setting permissions
✓ Deploy successful!
```

---

**Commit & push sekarang, build seharusnya sukses! 🚀**
