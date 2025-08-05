# Imagen base oficial de PHP con CLI
FROM php:8.2-cli

# Establecer directorio de trabajo
WORKDIR /var/www

# Instalar dependencias necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . /var/www

# Ajustar permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instalar dependencias del proyecto y AdminLTE
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader && \
    composer require jeroennoten/laravel-adminlte && \
    php artisan adminlte:install || echo "AdminLTE ya instalado"

# Exponer puerto
EXPOSE 8080

# Comando por defecto: migra, limpia caches y arranca servidor
CMD php artisan migrate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
