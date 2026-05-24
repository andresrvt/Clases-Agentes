#!/bin/bash
set -e

if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

chown -R www-data:www-data /var/www/html

exec "$@"