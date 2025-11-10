#!/bin/bash
# Build script untuk troubleshooting

set -e

echo "=== Sevalla Deployment Build Script ==="
echo ""

echo "[1/6] Checking environment..."
php -v
composer --version
node -v
npm -v
echo ""

echo "[2/6] Installing Composer dependencies..."
composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs
echo ""

echo "[3/6] Installing Node dependencies..."
npm ci --only=production || npm install --only=production
echo ""

echo "[4/6] Building assets..."
npm run build
echo ""

echo "[5/6] Setting up Laravel..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo ""

echo "[6/6] Setting permissions..."
chmod -R 775 storage bootstrap/cache
echo ""

echo "=== Build Complete! ==="
