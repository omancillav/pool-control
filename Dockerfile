# Imagen oficial de PHP con Composer
FROM php:8.2-cli

# Establece el directorio de trabajo
WORKDIR /var/www

# Instala dependencias necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    zip \
    curl \
    libpq-dev \
    libonig-dev \
    autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto
COPY . /var/www

# Ajusta permisos para Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instala dependencias de Laravel
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Expone el puerto que usará Laravel
EXPOSE 8080

# Comando por defecto: optimiza, migra y arranca servidor
CMD php artisan migrate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}