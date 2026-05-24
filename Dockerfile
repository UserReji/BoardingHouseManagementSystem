# Dockerfile for Laravel Boarding House Management System on Render.com
FROM php:8.3-fpm

# Install system dependencies + Python
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev libfreetype6-dev libjpeg62-turbo-dev libpq-dev \
    python3 python3-pip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ENV PYTHON_PATH=/usr/bin/python3
ENV APP_URL=https://YOUR_RENDER_URL.onrender.com
ENV NODE_ENV=production

COPY . .

# Create necessary directories
RUN mkdir -p /var/www/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# Install npm dependencies and build assets
RUN npm ci
RUN npm run build

# Install Python dependencies for PDF parsing
RUN pip3 install --no-cache-dir pdfplumber --break-system-packages

# Setup environment
RUN cp .env.example .env
RUN php artisan key:generate --force
RUN php artisan config:cache

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000
CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000