FROM php:8.2-fpm

# Instalar dependencias del sistema, incluyendo soporte para PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Instalar extensiones de PHP, incluyendo soporte para PostgreSQL
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar el código de la aplicación
COPY . .

# Instalar dependencias de PHP
RUN composer install --optimize-autoloader --no-dev

# Ejecutar comandos de optimización y migraciones
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force

# Configurar permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto
EXPOSE 10000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=10000