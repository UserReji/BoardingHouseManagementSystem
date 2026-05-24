# Dockerfile for Laravel Boarding House Management System on Render.com

# =========================
# BUILD STAGE
# =========================
FROM php:8.2-composer AS builder

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /app

# Copy composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Copy package files and install Node.js dependencies
COPY package.json package-lock.json vite.config.js ./
RUN npm install

# Copy application code
COPY . .

# Build frontend assets
RUN npm run build

# =========================
# PRODUCTION STAGE
# =========================
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy built assets and PHP dependencies from builder stage
COPY --from=builder /app/vendor ./vendor
COPY --from=builder /app/public ./public
COPY --from=builder /app/resources ./resources
COPY --from=builder /app/database ./database
COPY --from=builder /app/app ./app
COPY --from=builder /app/bootstrap ./bootstrap
COPY --from=builder /app/config ./config
COPY --from=builder /app/routes ./routes

# Copy .env.example as .env.template (will be overridden by Render env vars)
COPY --from=builder /app/.env.example .env.template

# Set permissions for storage and cache directories
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port (Render will set PORT environment variable)
EXPOSE 8000

# Use Laravel Octane for better performance
# Install Octane and Swoole
RUN pecl install swoole && docker-php-ext-enable swoole
RUN composer require laravel/octane --no-interaction --optimize-autoloader --no-dev
RUN php artisan octane:install --server=swoole --no-interaction

# Start Octane server using Render's PORT environment variable
CMD php artisan octane:start --host=0.0.0.0 --port=${PORT:-8000} --workers=2 --max-requests=1000