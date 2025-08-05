# Usa la imagen oficial PHP 8.2 con Apache
FROM php:8.2-apache

# Instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo_mysql

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia todo el código al directorio de Apache
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Cambia la raíz del documento de Apache a la carpeta "public"
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Permite usar .htaccess para que funcione el routing de Laravel
RUN echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/apache2.conf

# Habilita el módulo rewrite de Apache
RUN a2enmod rewrite

# Copia .env.example a .env si no existe (para que la app tenga configuración)
RUN [ -f .env ] || cp .env.example .env

# Instala dependencias PHP con Composer sin dev y optimiza autoload
RUN composer install --no-dev --optimize-autoloader

# Limpia configuración cacheada y genera la clave de Laravel
RUN php artisan config:clear && php artisan key:generate

# Ajusta permisos para que Apache pueda escribir en storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone puerto 80 para HTTP
EXPOSE 80

# Ejecuta Apache en primer plano (modo foreground)
CMD ["apache2-foreground"]
