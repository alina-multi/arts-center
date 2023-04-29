FROM phpswoole/swoole:php8.2

# Setup working directory
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install pcntl bcmath zip

#So we have a nice cache of vendor
COPY composer.lock /var/www
COPY composer.json /var/www
COPY nova-components /var/www/nova-components
RUN composer install --no-scripts --no-autoloader --no-dev --prefer-dist

#Now copy files that invalidate cache
COPY . /var/www

RUN chmod 0777 -R /var/www/storage/

#And run scripts and generate autoloader
RUN composer dump-autoload --optimize

COPY entrypoint.sh /usr/local/bin/
COPY .env.production .env
ENTRYPOINT ["entrypoint.sh"]
EXPOSE 8000

ENV LOG_CHANNEL=stderr

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0"]
