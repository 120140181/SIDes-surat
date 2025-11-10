# SIDes-Surat

Sistem Informasi Desa - Pengajuan Surat Online

## 🚀 Deploy ke Render.com

Aplikasi ini siap untuk di-deploy ke Render.com. Ikuti salah satu panduan berikut:

- **[Quick Deploy Guide](QUICK_DEPLOY.md)** - Panduan cepat untuk deployment
- **[Deployment Checklist](DEPLOYMENT_CHECKLIST.md)** - Checklist lengkap sebelum, saat, dan setelah deployment
- **[Deploy Documentation](DEPLOY_RENDER.md)** - Dokumentasi lengkap dan troubleshooting

### File Deployment yang Tersedia

- ✅ `render.yaml` - Blueprint configuration untuk automatic deployment
- ✅ `Dockerfile.render` - Docker configuration untuk Render.com
- ✅ `docker/entrypoint.sh` - Startup script
- ✅ `.dockerignore` - Optimasi Docker build

## Fitur Utama

- 📝 Pengajuan surat online oleh warga
- 👥 Multi-level approval (RT/RW/Kepala Desa)
- 📄 Generate surat otomatis
- 🔐 Autentikasi dan otorisasi berbasis role
- 📊 Dashboard monitoring
- 📱 Responsive design

## Tech Stack

- **Framework:** Laravel 12
- **Frontend:** AdminLTE 3, Vite
- **Database:** MySQL
- **Runtime:** PHP 8.2

## Development

### Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### Local Setup

```bash
# Clone repository
git clone <repository-url>
cd SIDes-Surat

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev

# Start server
php artisan serve
```

## Deployment

### Render.com (Recommended)

```bash
# 1. Push ke GitHub/GitLab
git push origin main

# 2. Buat Blueprint di Render.com
# - Login ke dashboard.render.com
# - New + → Blueprint
# - Connect repository
# - Apply

# 3. Done! 🎉
```

Lihat [QUICK_DEPLOY.md](QUICK_DEPLOY.md) untuk detail lengkap.

## License

MIT License

## Support

Untuk bantuan deployment, lihat dokumentasi di folder `/docs` atau file `DEPLOY_RENDER.md`.
