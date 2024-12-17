FROM php:8.4-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

RUN apk add --no-cache autoconf g++ make linux-headers && \
    pecl install xdebug && \
    docker-php-ext-install opcache && \
    docker-php-ext-enable xdebug && \
    apk del autoconf g++ make && \
    rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY docker/image/php/config/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY . /app
