# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd

# Habilita mod_rewrite de Apache (necesario para Laravel)
RUN a2enmod rewrite

# Copia Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia todos los archivos de la app
COPY . .

# Instala dependencias de PHP (Laravel)
RUN composer install --optimize-autoloader --no-dev || true

# Establece permisos correctos para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Configura Apache para Laravel (Rewrite y index.php)
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>' >> /etc/apache2/apache2.conf

# Expón el puerto que Render usará
EXPOSE 8080

# Comando de arranque
CMD ["apache2-foreground"]
