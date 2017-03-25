#!/bin/sh

# Navigate to the project directory and start maintenance
cd /var/www/mijn.svhelloworld.nl/html
php artisan down

# Navigate to the project directory and install dependencies
php artisan cache:clear
php artisan clear-compiled
composer install --no-dev --optimize-autoloader
cachetool opcache:reset
php artisan migrate --force

# Cache routes
php artisan route:cache
