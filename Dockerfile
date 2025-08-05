# 1. Usa una imagen base oficial de PHP con Apache
FROM php:8.2-apache

# 2. Instala las dependencias necesarias para Laravel y PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# 3. Instala Composer (gestor de dependencias PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copia todo el código de tu proyecto al contenedor
COPY . /var/www/html

# 5. Define el directorio de trabajo
WORKDIR /var/www/html

# 6. Da permisos necesarios a storage y cache para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# 7. Habilita mod_rewrite de Apache para URLs amigables
RUN a2enmod rewrite

# 8. Instala las dependencias PHP de Laravel (sin dev)
RUN composer install --no-dev --optimize-autoloader

# 9. Copia el archivo .env.example a .env si no existe
RUN [ -f .env ] || cp .env.example .env

# 10. Genera la clave de Laravel
RUN php artisan key:generate

# 11. Expone el puerto 80 para HTTP
EXPOSE 80

# 12. Inicia Apache en primer plano
CMD ["apache2-foreground"]
