# Imagen oficial de PHP con Composer
FROM php:8.2-cli

# Establece el directorio de trabajo
WORKDIR /var/www

# Instala dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    zip \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto
COPY . /var/www

# Da permisos a la carpeta de Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Instala las dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expone el puerto que usará Laravel
EXPOSE 8080

# Comando por defecto para iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
