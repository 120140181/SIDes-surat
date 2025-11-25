# SIDes-Surat Deployment Script (Windows)
# Jalankan setelah git pull di production

Write-Host "🚀 Starting deployment..." -ForegroundColor Green

# Create storage directories if not exist
Write-Host "📁 Creating storage directories..." -ForegroundColor Cyan
New-Item -ItemType Directory -Force -Path "storage\app\public\dokumen_pengajuan" | Out-Null
New-Item -ItemType Directory -Force -Path "storage\framework\cache" | Out-Null
New-Item -ItemType Directory -Force -Path "storage\framework\sessions" | Out-Null
New-Item -ItemType Directory -Force -Path "storage\framework\views" | Out-Null
New-Item -ItemType Directory -Force -Path "storage\logs" | Out-Null

# Create storage symlink
Write-Host "🔗 Creating storage symlink..." -ForegroundColor Cyan
php artisan storage:link

# Clear all caches
Write-Host "🧹 Clearing caches..." -ForegroundColor Cyan
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
Write-Host "⚡ Optimizing..." -ForegroundColor Cyan
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host "✅ Deployment completed!" -ForegroundColor Green
Write-Host ""
Write-Host "📝 Manual steps (if needed):" -ForegroundColor Yellow
Write-Host "1. Update .env file if needed"
Write-Host "2. Run: php artisan db:seed (first time only)"
Write-Host "3. Check storage folder exists"
