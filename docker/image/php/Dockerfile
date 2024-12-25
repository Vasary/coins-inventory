FROM dunglas/frankenphp:1.3-php8.4-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV FRANKENPHP_LISTEN=:80

RUN apk add --no-cache icu-dev autoconf g++ make linux-headers git && \
    pecl install xdebug  && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl  && \
    apk del autoconf g++ make && \
    rm -rf /var/cache/apk/*

COPY /docker/image/php/config/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . /app

