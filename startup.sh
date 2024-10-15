#!/bin/sh

# Run database migrations and seeders
php artisan migrate --seed
php artisan db:seed --class=StockSymbolsSeeder
php artisan stocks:fetch
php artisan cache:update

# Start PHP-FPM
php-fpm -y /usr/local/etc/php-fpm.conf -R