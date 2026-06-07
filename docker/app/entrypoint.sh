#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html

if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
    su -s /bin/bash www-data -c "composer install --no-interaction --prefer-dist --optimize-autoloader"
fi

exec "$@"