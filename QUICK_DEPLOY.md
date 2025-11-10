# Panduan Cepat Deploy ke Render.com

## Langkah-Langkah Singkat

### 1. Persiapan Repository
```bash
# Pastikan semua file sudah ter-commit
git add .
git commit -m "Add Render deployment configuration"
git push origin main
```

### 2. Deploy di Render.com

#### Opsi A: Menggunakan Blueprint (REKOMENDASI - Otomatis)
1. Login ke https://dashboard.render.com
2. Klik **"New +"** → **"Blueprint"**
3. Pilih repository Anda (GitHub/GitLab)
4. Render akan deteksi `render.yaml` secara otomatis
5. Klik **"Apply"**
6. Tunggu 5-10 menit sampai selesai

#### Opsi B: Manual Setup
1. Buat Database dulu:
   - **New +** → **MySQL**
   - Name: `sides-surat-db`
   - Region: **Singapore**
   - Plan: **Free**

2. Buat Web Service:
   - **New +** → **Web Service**
   - Connect repository
   - Name: `sides-surat`
   - Runtime: **Docker**
   - Dockerfile: `Dockerfile.render`
   - Region: **Singapore**
   - Plan: **Free**
   - Tambahkan environment variables (lihat DEPLOY_RENDER.md)

### 3. Set APP_URL
Setelah service dibuat:
1. Copy URL dari Render (contoh: `https://sides-surat.onrender.com`)
2. Masuk ke **Environment**
3. Edit `APP_URL` dengan URL tersebut
4. Save & Redeploy

### 4. Selesai! 🎉
Akses aplikasi Anda di URL yang diberikan.

## Troubleshooting Cepat

**Build Failed?**
- Cek Logs di Render Dashboard
- Pastikan `composer.json` dan `package.json` valid

**Database Error?**
- Tunggu database benar-benar ready (1-2 menit)
- Cek environment variables DB_*

**500 Error?**
- Buka Shell di Render: `php artisan migrate --force`
- Cek logs: Service → Logs tab

**Aplikasi Lambat/Sleep?**
- Normal untuk free tier (sleep setelah 15 menit)
- Akses pertama akan butuh 30-60 detik

## File Penting

- ✅ `render.yaml` - Konfigurasi Blueprint
- ✅ `Dockerfile.render` - Docker image untuk Render
- ✅ `docker/entrypoint.sh` - Script startup
- ✅ `DEPLOY_RENDER.md` - Dokumentasi lengkap

## Akses Admin Default

Jika menggunakan seeder:
- Email: admin@example.com
- Password: password

**PENTING:** Ganti password setelah deploy!

## Update Aplikasi

```bash
git add .
git commit -m "Update feature"
git push origin main
```
Render akan auto-deploy.

---

**Butuh bantuan lebih?** Baca `DEPLOY_RENDER.md` untuk panduan lengkap.
