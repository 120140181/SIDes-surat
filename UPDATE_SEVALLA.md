# 🔄 Cara Update Aplikasi di Sevalla

## TL;DR - Cara Cepat Update

### ✅ Dengan Auto-Deploy (RECOMMENDED):

```bash
# 1. Edit code di local
# 2. Commit & push
git add .
git commit -m "Update feature"
git push origin main

# 3. Sevalla otomatis deploy! ✅
# 4. Wait ~10 minutes
# 5. Done! 🎉
```

### ✅ Manual Redeploy (Jika auto-deploy belum aktif):

```bash
# 1. Push ke GitHub
git push origin main

# 2. Buka Sevalla Dashboard
# 3. Klik tombol "Redeploy" atau "Deploy"
# 4. Wait ~10 minutes
# 5. Done! 🎉
```

---

## 📋 Detail: Auto-Deploy Setup

### Cara Mengaktifkan Auto-Deploy:

1. **Login ke Sevalla Dashboard**
   - https://sevalla.com/dashboard

2. **Pilih Application Anda**
   - Klik pada application "SIDes-Surat"

3. **Buka Settings**
   - Cari menu "Settings" atau "Configuration"
   - Masuk ke bagian "Deployment" atau "Git"

4. **Enable Auto-Deploy**
   - Toggle/checkbox: **"Enable Automatic Deployments"**
   - Branch: `main` (atau branch yang Anda gunakan)
   - Save/Update

5. **Verify Connection**
   - Pastikan GitHub repository connected
   - Check webhook status (biasanya otomatis dibuat)

### GitHub Webhook (Optional - biasanya otomatis):

Jika perlu setup manual:

1. **Sevalla Dashboard:**
   - Copy webhook URL (biasanya ada di settings)

2. **GitHub Repository:**
   - Settings → Webhooks → Add webhook
   - Paste URL dari Sevalla
   - Content type: `application/json`
   - Events: `Just the push event`
   - Active: ✅
   - Save

---

## 🔄 Workflow Setelah Auto-Deploy Aktif

### Setiap Kali Update Code:

```bash
# 1. Development di local
# Edit files...

# 2. Test di local (optional tapi recommended)
php artisan serve
# Test di browser

# 3. Commit perubahan
git add .
git commit -m "Add feature XYZ"

# 4. Push ke GitHub
git push origin main

# 5. Sevalla akan otomatis:
# ✅ Detect push baru (5-30 detik)
# ✅ Pull latest code
# ✅ Build Docker image (5-10 menit)
# ✅ Deploy container baru
# ✅ Switch traffic (zero downtime)
# ✅ Old container dihapus

# 6. Check hasil
# Buka URL aplikasi Anda
# Atau check Sevalla Dashboard → Deployments
```

### Monitor Deploy Progress:

1. **Sevalla Dashboard:**
   - Lihat tab "Deployments" atau "Activity"
   - Status akan berubah:
     - ⏳ "Building..."
     - ⏳ "Deploying..."
     - ✅ "Active" / "Running"

2. **View Logs:**
   - Klik deployment yang sedang berjalan
   - View build logs untuk debug
   - View runtime logs untuk errors

---

## ❌ Yang TIDAK Boleh Dilakukan

### JANGAN Destroy & Create Ulang!

❌ **SALAH:**
```
1. Delete/Destroy application
2. Create new application
3. Setup from scratch
```

**Kenapa salah?**
- Database akan hilang! 💀
- Environment variables hilang
- Domain/URL berubah
- Settings custom hilang
- Setup ulang dari awal (buang waktu!)

✅ **BENAR:**
```
1. Push code update ke GitHub
2. Sevalla auto-deploy ATAU klik Redeploy
3. Done! (database & settings tetap aman)
```

---

## 🔧 Manual Deploy (Tanpa Auto-Deploy)

Jika auto-deploy belum aktif atau tidak mau pakai:

### Opsi 1: Redeploy Button

1. Login ke Sevalla Dashboard
2. Pilih application Anda
3. Klik tombol **"Redeploy"** atau **"Deploy"**
4. Confirm
5. Wait ~10 minutes
6. Done!

### Opsi 2: Via API/CLI (Advanced)

Jika Sevalla punya CLI tool:

```bash
# Install CLI (check Sevalla docs)
npm install -g @sevalla/cli  # atau cara install lainnya

# Login
sevalla login

# Deploy
sevalla deploy --app sides-surat

# Check status
sevalla status --app sides-surat
```

---

## 🎯 Best Practices

### 1. Always Test Locally First

```bash
# Test build
docker build -t test-app .

# Test run
docker run -p 8080:80 test-app

# Open browser
http://localhost:8080
```

### 2. Commit Messages yang Jelas

```bash
# ❌ Bad
git commit -m "fix"
git commit -m "update"

# ✅ Good
git commit -m "Fix user login validation"
git commit -m "Add export to Excel feature"
git commit -m "Update dashboard UI design"
```

### 3. Deploy di Waktu yang Tepat

- ✅ Deploy saat traffic rendah (malam/dini hari)
- ✅ Inform user jika ada downtime
- ✅ Backup database sebelum major update

### 4. Monitor After Deploy

```bash
# Check aplikasi running
curl -I https://your-app.sevalla.com

# Check logs
# Sevalla Dashboard → Logs

# Test fitur yang diupdate
# Manual testing di browser
```

---

## 🐛 Troubleshooting Deploy

### Deploy Gagal (Build Error)

1. **Check Build Logs:**
   - Sevalla Dashboard → Deployments → View Logs
   - Cari error message

2. **Common Issues:**
   - Composer install error → Check `composer.json`
   - NPM build error → Check `package.json`
   - Docker error → Check `Dockerfile`

3. **Fix & Redeploy:**
   ```bash
   # Fix error di local
   # Test build locally
   docker build -t test .
   
   # Jika OK, push
   git add .
   git commit -m "Fix build error"
   git push origin main
   ```

### Deploy Sukses tapi App Error (500)

1. **Check Runtime Logs:**
   - Sevalla Dashboard → Logs (Runtime/Application logs)

2. **Common Issues:**
   - Database connection → Check env vars
   - Missing APP_KEY → Set di environment
   - Migration needed → Run migration

3. **Run Migration:**
   - Sevalla Dashboard → Console/Shell
   ```bash
   php artisan migrate --force
   ```

### Auto-Deploy Tidak Trigger

1. **Check Webhook:**
   - GitHub → Settings → Webhooks
   - Find Sevalla webhook
   - Check recent deliveries
   - Redeliver jika failed

2. **Manual Redeploy:**
   - Sevalla Dashboard → Redeploy button

3. **Verify Connection:**
   - Sevalla → Settings → Git
   - Reconnect if needed

---

## 📊 Deploy Status & Timeline

### Normal Deploy Timeline:

| Stage | Duration | Description |
|-------|----------|-------------|
| Push to GitHub | ~1s | `git push` |
| Webhook trigger | 5-30s | Sevalla detect push |
| Build start | ~10s | Pull code, start build |
| Docker build | 5-10min | Install deps, build assets |
| Deploy | 1-2min | Start container |
| Health check | 10-30s | Verify app running |
| **Total** | **~10min** | From push to live |

### Status Indicators:

- 🟡 **Pending** - Waiting to start
- 🔵 **Building** - Docker build in progress
- 🟣 **Deploying** - Starting container
- 🟢 **Active/Running** - Successfully deployed! ✅
- 🔴 **Failed** - Error occurred, check logs ❌

---

## 🎓 Tips & Tricks

### 1. Use `.env.example` dengan Benar

Pastikan `.env.example` updated:
```bash
# Setiap tambah env var baru
# Update .env.example (jangan commit .env!)
git add .env.example
git commit -m "Add new env var to example"
```

### 2. Database Migrations

Jika ada migration baru:
```bash
# Setelah deploy, run di Sevalla console:
php artisan migrate --force
```

Atau setup auto-migration di `Dockerfile`:
```dockerfile
# Tambah di entrypoint/CMD
CMD php artisan migrate --force && apache2-foreground
```

### 3. Cache Optimization

Setelah deploy major update:
```bash
# Di Sevalla console
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Rollback Strategy

Jika deploy bermasalah:
- Sevalla Dashboard → Deployments
- Find previous working deployment
- Click "Redeploy" atau "Rollback"

Atau via git:
```bash
# Revert last commit
git revert HEAD
git push origin main
# Sevalla auto-deploy previous version
```

---

## ✅ Checklist Update

Before deploy:
- [ ] Code tested locally
- [ ] Docker build tested
- [ ] Commit message clear
- [ ] Database migrations ready (if any)
- [ ] .env.example updated (if new vars)

After deploy:
- [ ] Check deploy status (Active/Running)
- [ ] Test aplikasi di browser
- [ ] Check logs for errors
- [ ] Run migrations (if needed)
- [ ] Test main features

---

## 🆘 Need Help?

**Quick Links:**
- Sevalla Dashboard: https://sevalla.com/dashboard
- Sevalla Docs: https://sevalla.com/docs
- GitHub Webhooks: Settings → Webhooks
- Application Logs: Dashboard → Logs

**Support:**
- Sevalla Support Team
- Documentation: Check `SEVALLA_DEPLOY.md`
- Community: Laravel forums/Discord

---

**Happy Deploying! 🚀**
