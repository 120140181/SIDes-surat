# 🚨 Troubleshooting: Error Composer Install di Sevalla

## Error yang Sama Masih Muncul?

### ✅ Checklist Penyebab:

#### 1. **Repository Private** ⚠️ (KEMUNGKINAN BESAR INI!)

**Masalah:**
- Sevalla tidak bisa clone/pull repository private
- Access denied saat build

**Solusi:**

##### Opsi A: Ubah ke Public (TERMUDAH) ⭐

```
GitHub Repository:
1. Settings
2. Scroll ke bawah → "Danger Zone"
3. "Change repository visibility"
4. "Make public"
5. Type repository name untuk confirm
6. Confirm
```

**Keamanan:**
- ✅ `.env` tidak ter-commit (aman)
- ✅ Sensitive data di environment variables (tidak di code)
- ✅ Password/API keys tidak di-commit

##### Opsi B: Setup Deploy Key (Advanced)

Jika harus tetap private:

**Di Sevalla:**
1. Dashboard → Application Settings
2. Git/Deploy Keys section
3. Copy SSH public key yang diberikan

**Di GitHub:**
1. Repository → Settings → Deploy keys
2. Add deploy key
3. Title: "Sevalla Deploy"
4. Paste key dari Sevalla
5. ✅ Allow read access (cukup, jangan write)
6. Add key

**Update di Sevalla:**
- Change Git URL from HTTPS to SSH:
  - ❌ `https://github.com/120140181/SIDes-surat.git`
  - ✅ `git@github.com:120140181/SIDes-surat.git`

---

#### 2. **Dockerfile Duplikasi** ✅ (SUDAH DIPERBAIKI)

File `Dockerfile` sudah diperbaiki, tidak ada duplikasi lagi.

---

#### 3. **Composer.lock Tidak Ter-commit**

Cek apakah `composer.lock` ada di repository:

```powershell
# Check apakah composer.lock ada
ls composer.lock

# Jika ada, pastikan ter-commit
git add composer.lock
git commit -m "Add composer.lock"
git push origin main
```

**Kenapa penting?**
- Composer butuh `composer.lock` untuk reproduksi exact dependencies
- Tanpa lock file, bisa install versi yang berbeda

---

#### 4. **Build Context Issue**

Cek file `.dockerignore`:

```powershell
# Lihat isi .dockerignore
cat .dockerignore
```

Pastikan `composer.json` dan `composer.lock` **TIDAK** di-ignore:

```
# .dockerignore
node_modules/
.git
.env
vendor/  # Ini OK di-ignore, akan di-install di build

# Pastikan TIDAK ada:
# composer.json  ← JANGAN ignore ini!
# composer.lock  ← JANGAN ignore ini!
```

---

#### 5. **Memory Limit**

Tambahkan memory limit di Dockerfile:

```dockerfile
# Tambahkan sebelum composer install
ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
```

---

## 🔧 Quick Fix: Try Dockerfile Minimal

File `Dockerfile.minimal` sudah dibuat. Coba gunakan ini:

```powershell
# Backup Dockerfile lama
mv Dockerfile Dockerfile.backup

# Gunakan minimal version
mv Dockerfile.minimal Dockerfile

# Commit & push
git add Dockerfile
git commit -m "Use minimal Dockerfile for debugging"
git push origin main
```

**Dockerfile.minimal includes:**
- ✅ `--ignore-platform-reqs` flag
- ✅ Minimal dependencies
- ✅ Simplified build process
- ✅ Better error messages

---

## 🧪 Test Build Locally

Sebelum push, test dulu:

```powershell
# Build dengan Dockerfile baru
docker build -t test-app .

# Jika error muncul, lihat di line mana
# Jika sukses, image siap!
docker images | grep test-app
```

---

## 📋 Step-by-Step Fix

### Step 1: Ubah Repository ke Public

```
GitHub → Repository Settings → Change visibility → Public
```

### Step 2: Perbaiki Dockerfile

```powershell
# Dockerfile sudah diperbaiki, commit
git add Dockerfile
git commit -m "Fix Dockerfile duplication"
git push origin main
```

### Step 3: Verify composer.lock

```powershell
# Check composer.lock exists and committed
git ls-files | grep composer.lock

# Jika tidak ada output, add it:
git add composer.lock
git commit -m "Add composer.lock"
git push origin main
```

### Step 4: Redeploy di Sevalla

```
Sevalla Dashboard → Redeploy button
atau
Auto-deploy akan trigger dari push
```

### Step 5: Monitor Build Logs

```
Sevalla Dashboard → Deployments → View Logs
```

---

## 🔍 Diagnosa Error Logs

### Error: "failed to solve: process ... did not complete successfully: exit code: 1"

**Penyebab:**
- Composer install gagal
- File tidak ditemukan
- Permission denied
- Memory limit

**Lihat logs detail:**
- Scroll ke atas error
- Cari pesan error spesifik dari composer
- Biasanya ada pesan seperti:
  ```
  Loading composer repositories with package information
  Installing dependencies from lock file
  [ERROR] Specific error message here
  ```

### Error: "composer.json not found"

**Penyebab:**
- Repository clone gagal (private repo issue!)
- File di-ignore di .dockerignore
- Working directory salah

**Fix:**
1. Ubah ke public repository
2. Check .dockerignore
3. Verify COPY command di Dockerfile

### Error: "memory limit"

**Fix:**
```dockerfile
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install ...
```

---

## 🎯 Most Likely Solution

**99% masalahnya adalah Private Repository!**

### Quick Test:

1. **Ubah repository ke PUBLIC**
   - GitHub → Settings → Make public

2. **Trigger redeploy di Sevalla**
   - Manual redeploy atau
   - Push dummy commit:
     ```powershell
     git commit --allow-empty -m "Trigger rebuild"
     git push origin main
     ```

3. **Tunggu build selesai**
   - Monitor logs di Sevalla

4. **Jika berhasil:**
   - Problem solved! It was the private repo! ✅

5. **Jika masih error:**
   - Screenshot full error log
   - Paste di sini untuk diagnosa lebih lanjut

---

## 💡 Alternative: Dockerfile Super Minimal

Jika semua gagal, coba ini (copy paste ke Dockerfile):

```dockerfile
FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite

COPY . .
RUN composer install --no-dev --no-interaction --ignore-platform-reqs || true
RUN chown -R www-data:www-data storage bootstrap/cache || true
RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 80
CMD ["apache2-foreground"]
```

**Note:** `|| true` makes it continue even if some commands fail (for debugging)

---

## 📞 Next Steps

1. ✅ **Ubah ke Public repository** (coba ini dulu!)
2. ✅ Commit Dockerfile yang sudah diperbaiki
3. ✅ Push & redeploy
4. ✅ Check logs

**Jika masih error:**
- Screenshot **FULL** error log (dari awal build sampai error)
- Paste di sini
- Kita debug lebih detail

---

## ✅ Verification Checklist

Before redeploy:
- [ ] Repository visibility: Public (recommended) atau Deploy key setup
- [ ] `Dockerfile` tidak ada duplikasi
- [ ] `composer.lock` ter-commit
- [ ] `.dockerignore` tidak block `composer.json`/`composer.lock`
- [ ] Test build locally: `docker build -t test .`

After deploy:
- [ ] Check build logs untuk error messages
- [ ] Verify application running
- [ ] Test URL di browser

---

**Try ubah ke public repository dulu, ini penyebab paling umum! 🎯**
