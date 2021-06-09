FROM php:8-fpm-alpine

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
    libzip-dev

RUN docker-php-ext-configure zip
RUN docker-php-ext-install \
    curl \
    pdo \
    pdo_mysql \
    pcntl

RUN pecl install redis && docker-php-ext-enable redis

# Install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# Cleanup dev dependencies
RUN apk del -f .build-deps

# 256mb should be enough? I hope
RUN echo "php_admin_value[memory_limit] = 256M" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

# Setup working directory
WORKDIR /var/www

#So we have a nice cache of vendor
COPY composer.lock /var/www
COPY composer.json /var/www
RUN composer install --no-scripts --no-autoloader

#Now copy files that invalidate cache
COPY . /var/www

RUN chmod 0777 -R /var/www/storage/

#And run scripts and generate autoloader
RUN composer dump-autoload --optimize

COPY entrypoint.sh /usr/local/bin/
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
