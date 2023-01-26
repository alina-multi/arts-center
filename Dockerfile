FROM php:8-alpine
# Install dev dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    curl-dev \
    libtool \
    libxml2-dev

# Install production dependencies
RUN apk add --no-cache \
    mysql-client \
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev

RUN docker-php-ext-configure zip && docker-php-ext-configure gd --with-jpeg

RUN docker-php-ext-install \
    curl \
    pdo \
    pdo_mysql \
    pcntl \
    gd \
    opcache \
    bcmath


RUN pecl install redis swoole && docker-php-ext-enable redis swoole

# Cleanup dev dependencies
RUN apk del -f .build-deps

# Override defaults
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Setup working directory
WORKDIR /var/www
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

#So we have a nice cache of vendor
COPY composer.lock /var/www
COPY composer.json /var/www
COPY nova-components /var/www/nova-components
RUN composer install --no-scripts --no-autoloader

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
