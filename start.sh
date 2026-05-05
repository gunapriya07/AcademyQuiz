#!/bin/sh

# Fix ownership (VERY IMPORTANT)
chown -R www-data:www-data /var/www

# Fix permissions
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Start services
php-fpm &
nginx -g "daemon off;"