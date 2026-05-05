#!/bin/sh

# Fix permissions FIRST
chmod -R 775 storage bootstrap/cache

# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild cache
php artisan config:cache

# Run migrations
php artisan migrate --force

# Start services
php-fpm &
nginx -g "daemon off;"