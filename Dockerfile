FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Ejecuta adminlte:install solo si no está instalado (evita error si ya existe)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader && \
    php artisan adminlte:install || echo "AdminLTE ya instalado"

EXPOSE 8080

CMD php artisan migrate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
