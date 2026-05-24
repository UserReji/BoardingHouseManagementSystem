# Dockerfile for Laravel Boarding House Management System on Render.com
FROM php:8.3-fpm

# Install system dependencies and Node.js 20 in a single layer to reduce image size
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    ca-certificates \
    gnupg \
    lsb-release \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    python3 \
    python3-pip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (gd needs configure first)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ── Composer dependencies (cached layer unless composer.json/lock changes) ──
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader

# ── NPM dependencies (cached layer unless package.json/lock changes) ──
COPY package.json package-lock.json ./
RUN npm ci

# ── Copy the rest of the application source ──
COPY . .

# Finish Composer autoloader now that all source files are present
RUN composer dump-autoload --no-dev --optimize

# Create required Laravel storage directories
RUN mkdir -p /var/www/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache

# Build frontend assets (Vite + Tailwind CSS v4)
RUN npm run build && npm cache clean --force

# Install Python dependency for PDF parsing (pdfplumber)
RUN pip3 install --no-cache-dir pdfplumber --break-system-packages

# ── Environment & Laravel bootstrap ──
# Copy .env.example → .env only if .env was not shipped (Render injects secrets
# via environment variables at runtime, so key:generate here is just a fallback)
RUN cp .env.example .env \
    && php artisan key:generate --force

# Create the storage symlink so public/storage works
RUN php artisan storage:link || true

# Fix ownership so php-fpm (www-data) can write to storage/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ── Runtime environment ──
ENV NODE_ENV=production
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PYTHON_PATH=/usr/bin/python3
# Override APP_URL at deploy time via Render's environment variables panel
ENV APP_URL=https://boardinghousemanagementsystem-xzcx.onrender.com

EXPOSE 8000

# Clear stale caches baked in from the build, re-cache with live env vars,
# run migrations, then start the built-in server.
# NOTE: For production traffic use a proper web server (nginx + php-fpm).
#       php artisan serve is fine for Render's free/hobby tier.
CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000