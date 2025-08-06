# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Activar mod_rewrite para Laravel
RUN a2enmod rewrite

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . .

# Ajustar permisos para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Instalar dependencias de Composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Instalar AdminLTE si no se hizo antes
RUN php artisan adminlte:install --force

# Publicar assets de AdminLTE (CSS, JS, etc.)
RUN php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\AdminLteServiceProvider" --tag=assets --force

# Generar la clave solo si no existe .env
# (si ya tienes APP_KEY configurada en Render, puedes omitir esto)
RUN if [ ! -f .env ]; then cp .env.example .env && php artisan key:generate; fi

# Cachear configuración
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Puerto que usará Apache (Render redirige al interno)
EXPOSE 80

# Comando por defecto: iniciar Apache en primer plano
CMD ["apache2-foreground"]
