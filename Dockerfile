FROM phpswoole/swoole:5.0.1-php8.2-alpine

# Setup working directory
WORKDIR /var/www

RUN docker-php-ext-install pcntl bcmath

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

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0"]
