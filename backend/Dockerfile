FROM phpswoole/swoole:5.1-php8.2-alpine

# Setup working directory
WORKDIR /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pcntl bcmath zip gd exif intl

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
EXPOSE 8000

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini
ENTRYPOINT ["php"]
CMD ["artisan", "octane:start", "--host=0.0.0.0", "--log-level=notice"]
