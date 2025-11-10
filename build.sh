#!/bin/bash

# Build script for Render
echo "Starting build process..."

# Install Composer dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies
echo "Installing Node dependencies..."
npm ci

# Build assets
echo "Building frontend assets..."
npm run build

# Clear any existing caches
echo "Clearing Laravel caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

echo "Build complete!"
