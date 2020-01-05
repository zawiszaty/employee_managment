FROM php:7.4.1-fpm

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

COPY entrypoint.sh /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]