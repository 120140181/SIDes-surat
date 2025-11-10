# 🔧 Fix: Vite Build Error - MODULE_NOT_FOUND

## ❌ Error yang Terjadi:

```
npm run build
Error: Cannot find module '@rollup/rollup-linux-x64-gnu'
code: 'MODULE_NOT_FOUND'
Node.js v18.20.5
ERROR: failed to solve: exit code: 1
```

## 🎯 Root Cause:

**Vite tidak ter-install** karena:
1. ❌ Dockerfile pakai `npm install --production`
2. ❌ Flag `--production` skip **devDependencies**
3. ❌ Vite ada di **devDependencies** (bukan dependencies)
4. ❌ npm run build butuh Vite untuk compile assets

## 📊 Apakah npm run build Penting?

### ✅ YA, SANGAT PENTING!

**npm run build** function:
- 🎨 Compile CSS dari `resources/css/app.css`
- 🎨 Compile JavaScript dari `resources/js/app.js`
- 🎨 Process Tailwind CSS
- 🎨 Optimize & minify assets
- 🎨 Output ke `public/build/`

### ❌ Jika Dihapus:

```
Website jalan tapi:
❌ Tanpa styling (broken layout)
❌ AdminLTE theme tidak muncul
❌ Tailwind CSS tidak ada
❌ JavaScript tidak berfungsi
❌ Tampilan berantakan
```

## ✅ Solusi: Install ALL Dependencies

### Perubahan di Dockerfile:

**❌ SEBELUM (SALAH):**
```dockerfile
# Install NPM dependencies with fallback
RUN npm install --production --no-optional || npm install --production --legacy-peer-deps
```

**✅ SESUDAH (BENAR):**
```dockerfile
# Install NPM dependencies INCLUDING devDependencies (needed for Vite build)
RUN npm install --legacy-peer-deps
```

### Kenapa Hapus `--production`?

| Flag | Effect | Issue |
|------|--------|-------|
| `--production` | Skip devDependencies | ❌ Vite tidak ter-install |
| (no flag) | Install ALL deps | ✅ Vite ter-install |
| `--legacy-peer-deps` | Bypass peer conflicts | ✅ Fix dependency issues |

## 🚀 Implementasi:

### 1. Update Dockerfile

```bash
# Sudah dilakukan:
- Dockerfile (main)
- Dockerfile.minimal
- Dockerfile.sevalla
```

### 2. Commit & Push

```bash
git add Dockerfile Dockerfile.minimal Dockerfile.sevalla FIX_VITE_BUILD_ERROR.md
git commit -m "Fix: Install all npm dependencies for Vite build (remove --production flag)"
git push origin main
```

### 3. Tunggu Sevalla Rebuild

Build seharusnya sukses sekarang:
```
✅ composer install → SUCCESS
✅ npm install (all deps) → SUCCESS
✅ npm run build → SUCCESS
✅ Docker build → SUCCESS
🎉 Application deployed!
```

## 📝 Catatan:

### Q: Apakah image size jadi lebih besar?

**A:** Ya, tapi kita cleanup setelah build:

```dockerfile
# Build assets
RUN npm run build

# Clean up node_modules to reduce image size
RUN rm -rf node_modules
```

Jadi:
1. ✅ Install all dependencies (termasuk Vite)
2. ✅ Build assets dengan Vite
3. ✅ Hapus node_modules setelah build
4. ✅ Final image tetap kecil

### Q: Alternatif lain?

**A:** Pre-build assets locally:

```bash
# Local:
npm install
npm run build
git add public/build
git commit -m "Add pre-built assets"
git push

# Dockerfile:
# Skip npm install & npm run build
# Karena public/build sudah ada
```

Tapi ini **tidak recommended** karena:
- ❌ Harus rebuild manual setiap kali ada perubahan
- ❌ Git repository jadi besar
- ❌ Build artifacts di version control (bad practice)

## ✅ Summary:

| Issue | Root Cause | Fix |
|-------|-----------|-----|
| Vite build error | `--production` skip devDeps | Remove `--production` flag |
| MODULE_NOT_FOUND | Vite not installed | Install all dependencies |
| Image size concern | node_modules included | Cleanup after build |

---

**Status:** ✅ Fixed  
**Commit:** Coming soon  
**Next:** Monitor Sevalla deployment
