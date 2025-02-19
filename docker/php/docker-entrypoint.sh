#!/bin/bash
set -e

cd /var/www/html

if [ -f composer.json ]; then
    composer install --no-interaction --optimize-autoloader
fi

exec php-fpm
