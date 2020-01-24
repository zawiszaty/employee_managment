FROM php:7.4.1-fpm-alpine3.11

COPY . /var/www/html

RUN apk update && \
		apk add --no-cache $PHPIZE_DEPS \
		git \
        libzip-dev \
        unzip \
        zip \
        nginx \
        libpng-dev \
        && pecl install xdebug-2.9.0 \
  		&& docker-php-ext-install zip \
  		&& docker-php-ext-install pdo_mysql \
  		&& docker-php-ext-install bcmath sockets pcntl gd \
  		&& docker-php-ext-enable xdebug

COPY ./.docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

ENTRYPOINT ["/var/www/html/.docker/entrypoint.sh"]
