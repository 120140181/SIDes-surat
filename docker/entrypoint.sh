#!/bin/bash
set -e

echo "Starting deployment process..."

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:show 2>/dev/null; do
    echo "Database is unavailable - sleeping"
    sleep 2
done

echo "Database is ready!"

# Create .env if not exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Generate application key if not set
if grep -q "APP_KEY=$" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Seed database if needed (optional - remove if you don't want to seed on every deploy)
# echo "Seeding database..."
# php artisan db:seed --force --no-interaction

# Cache config and routes for better performance
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

echo "Deployment complete! Starting Apache..."

# Execute the main command
exec "$@"
