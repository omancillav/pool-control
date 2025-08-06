# Imagen base con Apache
FROM php:8.2-apache

# Activar mod_rewrite para Laravel
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todo el proyecto Laravel
COPY . .

# Asignar permisos a las carpetas necesarias
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Instalar dependencias del proyecto
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Instalar AdminLTE y publicar assets
RUN php artisan adminlte:install --force && \
    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\AdminLteServiceProvider" --tag=assets --force

# Exponer puerto
EXPOSE 80

# Comando de inicio en Render (migración primero, luego caches, luego servidor)
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground
