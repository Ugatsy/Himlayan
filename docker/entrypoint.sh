#!/bin/sh
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=" .env || [ "$(grep '^APP_KEY=' .env | cut -d= -f2)" = "" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force

php artisan storage:link --force 2>/dev/null || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
