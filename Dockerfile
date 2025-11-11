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
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
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

# Configure Apache to listen on port 8080 (Sevalla requirement)
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf && \
    sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

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
# Clean cache first and remove package-lock.json to fix npm optional dependencies bug
RUN rm -f package-lock.json && \
    npm cache clean --force && \
    npm install --legacy-peer-deps

# Copy Apache virtual host config
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy rest of application files
COPY . .

# No need for npm rebuild since we freshly installed without package-lock.json

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

# Expose port 8080 (Sevalla requirement)
EXPOSE 8080

CMD ["apache2-foreground"]
