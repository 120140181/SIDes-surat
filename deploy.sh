#!/bin/bash

# SIDes-Surat Deployment Script
# Jalankan setelah git pull di production

echo "🚀 Starting deployment..."

# Create storage directories if not exist
echo "📁 Creating storage directories..."
mkdir -p storage/app/public/dokumen_pengajuan
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (if needed)
# php artisan migrate --force

echo "✅ Deployment completed!"
echo ""
echo "📝 Manual steps (if needed):"
echo "1. Update .env file if needed"
echo "2. Run: php artisan db:seed (first time only)"
echo "3. Check file permissions: ls -la storage/"
echo "4. Check symlink: ls -la public/storage"
