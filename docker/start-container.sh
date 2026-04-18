#!/bin/sh
set -eu

cd /app

# Railway mounts the persistent volume at runtime, so we recreate the
# Laravel storage tree and SQLite file after the mount is attached.
mkdir -p \
  /app/storage/app/public \
  /app/storage/framework/cache \
  /app/storage/framework/sessions \
  /app/storage/framework/views \
  /app/storage/logs

touch /app/storage/app/database.sqlite

php artisan optimize:clear || true
php artisan storage:link || true
php artisan migrate --force || true

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
