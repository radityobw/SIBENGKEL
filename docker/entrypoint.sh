#!/usr/bin/env sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ] && grep -q '^APP_KEY=$' .env; then
  php artisan key:generate --force --no-interaction
fi

DB_CONN="${DB_CONNECTION:-sqlite}"
if [ "$DB_CONN" = "sqlite" ]; then
  mkdir -p database
  if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    php artisan migrate --force --no-interaction
  fi
fi

php artisan storage:link --force >/dev/null 2>&1 || true
chown -R www-data:www-data storage bootstrap/cache database

exec "$@"
