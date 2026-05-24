FROM php:8.3-cli

# System deps
RUN apt-get update && apt-get install -y \
    curl gnupg git unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libfreetype6-dev libjpeg62-turbo-dev libpq-dev \
    python3 python3-pip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache

RUN composer install --no-dev --optimize-autoloader
RUN pip3 install --no-cache-dir pdfplumber --break-system-packages

RUN cp .env.example .env \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD rm -f .env bootstrap/cache/config.php bootstrap/cache/routes*.php && \
    php artisan config:clear && \
    php artisan storage:link && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=8000