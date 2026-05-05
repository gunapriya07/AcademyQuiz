#!/bin/sh

php artisan config:clear
php artisan cache:clear
php artisan migrate --force

# Fix permissions again at runtime (important for Render)
chmod -R 775 storage bootstrap/cache

php-fpm &
nginx -g "daemon off;"