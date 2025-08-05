# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia .env.example a .env si no existe
RUN [ -f .env ] || cp .env.example .env

# Instala las dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Establece permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Genera la clave de Laravel (debes asegurarte de tener el archivo .env copiado antes)
RUN php artisan config:clear && php artisan key:generate

# Expone el puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
