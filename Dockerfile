# Base image PHP-FPM 8.3
FROM php:8.3-fpm

# Install dependencies & PostgreSQL PDO
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear

# Expose the port Laravel will run on
EXPOSE 8000

# Start Laravel with auto migrate & storage link
CMD php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=$PORT
