FROM php:8.2-apache

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git zip curl libpq-dev libonig-dev autoconf \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan adminlte:install --force
RUN php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\AdminLteServiceProvider" --tag=assets --force

RUN if [ ! -f .env ]; then cp .env.example .env && php artisan key:generate; fi

RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80

CMD ["apache2-foreground"]
