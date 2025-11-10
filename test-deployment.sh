#!/bin/bash
# Unix shell script to test entrypoint locally

echo "========================================"
echo "Testing Entrypoint Script (Unix/Linux)"
echo "========================================"
echo ""

echo "[1/6] Checking PHP..."
php -v
if [ $? -ne 0 ]; then
    echo "ERROR: PHP not found!"
    exit 1
fi
echo ""

echo "[2/6] Checking Composer..."
composer --version
if [ $? -ne 0 ]; then
    echo "ERROR: Composer not found!"
    exit 1
fi
echo ""

echo "[3/6] Checking .env file..."
if [ ! -f .env ]; then
    echo ".env not found, copying from .env.example..."
    cp .env.example .env
fi
echo ""

echo "[4/6] Generating APP_KEY if needed..."
php artisan key:generate
echo ""

echo "[5/6] Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo ""

echo "[6/6] Testing database connection..."
php artisan db:show
if [ $? -ne 0 ]; then
    echo "WARNING: Database not configured or not accessible"
    echo "This is OK for local development"
fi
echo ""

echo "========================================"
echo "Test Complete!"
echo "========================================"
echo ""
echo "Your environment is ready for deployment to Render.com"
echo ""
echo "Next steps:"
echo "1. git add ."
echo "2. git commit -m 'Ready for Render deployment'"
echo "3. git push origin main"
echo "4. Create Blueprint at render.com"
echo ""
