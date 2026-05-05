#!/bin/sh

php artisan config:clear
php artisan cache:clear

#  THIS IS THE IMPORTANT LINE
php artisan migrate --force

php-fpm &
nginx -g "daemon off;"