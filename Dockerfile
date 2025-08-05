# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala dependencias para extensiones y utilidades
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo_mysql

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia todo tu código al directorio de Apache
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Ejecuta Composer install sin dependencias de desarrollo y optimizando autoload
RUN composer install --no-dev --optimize-autoloader

# Genera la clave de Laravel
RUN php artisan key:generate

# Ajusta permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone el puerto 80
EXPOSE 80

# Inicia Apache en primer plano
CMD ["apache2-foreground"]
