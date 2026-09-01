FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default

# Ép PHP-FPM lắng nghe cổng 9000
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 80

CMD php artisan config:clear && \
    php artisan storage:link --force && \
    php-fpm -D && \
    nginx -g "daemon off;"