#!/bin/sh

#Cache and optimize stuff so it will work fast!
php artisan optimize
php artisan view:cache

exec docker-php-entrypoint "$@"


