FROM php:8.2-apache

# Activar mod_rewrite y configurar Apache para Laravel
RUN a2enmod rewrite

# Copiar proyecto Laravel
COPY . /var/www/html

# Establecer permisos para carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependencias del sistema y PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias del proyecto
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Instalar AdminLTE y publicar assets (si no están ya instalados)
RUN php artisan adminlte:install --force || true && \
    php artisan vendor:publish --provider="JeroenNoten\\LaravelAdminLte\\AdminLteServiceProvider" --tag=assets --force || true

# Configurar Apache para servir la carpeta public/ de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 80

# Ejecutar comandos Laravel antes de arrancar Apache
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground
