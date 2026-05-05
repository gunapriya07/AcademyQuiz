#!/bin/sh

sed -i "s/LISTEN_PORT/${PORT}/g" /etc/nginx/conf.d/default.conf

# Fix permissions
chown -R www-data:www-data /var/www
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations
php artisan migrate --force

# Start services
php-fpm &
nginx -g "daemon off;"