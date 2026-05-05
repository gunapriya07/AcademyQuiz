#!/bin/sh

chmod -R 775 storage bootstrap/cache

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache

php artisan migrate --force

php-fpm &
nginx -g "daemon off;"