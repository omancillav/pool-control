# Usar una imagen base oficial de PHP con FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instalar extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar el código de la aplicación
COPY . .

# Instalar dependencias de PHP
RUN composer install --optimize-autoloader --no-dev

# Optimizar Laravel para producción
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Asegurar permisos correctos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto (Render usa el puerto 10000 por defecto)
EXPOSE 10000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=10000