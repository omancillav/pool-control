FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . .
RUN composer install --optimize-autoloader --no-dev
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000