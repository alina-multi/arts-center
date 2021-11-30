#!/bin/sh

until nc -z -v -w30 $DB_HOST $DB_PORT
do
  echo "Waiting for database connection..."
  # wait for 5 seconds before check again
  sleep 5
done
#Cache and optimize stuff so it will work fast!
php artisan optimize
php artisan view:cache

exec docker-php-entrypoint "$@"


