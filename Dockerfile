FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl zip unzip git libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Workdir
WORKDIR /var/www/html

# Copy project files
COPY . .

# Composer install
RUN composer install --no-dev --optimize-autoloader

# Permission fix
RUN chown -R www-data:www-data storage bootstrap/cache
