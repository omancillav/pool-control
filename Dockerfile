FROM php:8.2-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git \
    && docker-php-ext-install zip pdo_mysql

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código al contenedor
COPY . /var/www/html

WORKDIR /var/www/html

# Cambia el DocumentRoot a la carpeta public de Laravel
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Habilita mod_rewrite para URLs amigables de Laravel
RUN a2enmod rewrite

# Permite que Apache use .htaccess y reconozca index.php
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copia .env si no existe (opcional, para entorno local)
RUN [ -f .env ] || cp .env.example .env

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Ajusta permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Genera la clave de Laravel
RUN php artisan key:generate

# Expone el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]
