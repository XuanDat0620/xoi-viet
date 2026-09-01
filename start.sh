#!/bin/sh

php artisan config:clear
php artisan storage:link --force

# Khởi chạy PHP-FPM ở background
php-fpm -D

# Khởi chạy Nginx ở foreground để giữ container chạy liên tục
nginx -g "daemon off;"