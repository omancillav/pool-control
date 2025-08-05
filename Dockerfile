FROM php:8.2-fpm

# Instala dependencias del sistema y extensiones de PHP requeridas por Laravel y Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el código de la aplicación
COPY . .

# Copia la configuración de Nginx
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default

# Da permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instala dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Expone el puerto 80
EXPOSE 80

# Inicia PHP-FPM y Nginx
CMD service php8.2-fpm start && nginx -g 'daemon off;'