# Dockerfile optimized for Sevalla
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and Node.js in one layer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    default-mysql-client \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        sockets \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies without running scripts
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --no-interaction

# Copy package files
COPY package*.json ./

# Install NPM dependencies INCLUDING devDependencies (needed for Vite build)
# Clean cache first to avoid platform mismatch issues
RUN npm cache clean --force && npm install --legacy-peer-deps

# Copy Apache virtual host config
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy rest of application files
COPY . .

# Rebuild native modules for Linux platform
RUN npm rebuild

# Complete composer installation with autoloader
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Build frontend assets
RUN npm run build

# Clean up node_modules to reduce image size
RUN rm -rf node_modules

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 storage bootstrap/cache

# Create .env from example if not exists
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
