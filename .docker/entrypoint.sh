#!/bin/sh
set -e
if [ "${SKIP_COMPOSER_INSTALL:0}" != "1" ]; then
	cd /var/www/html && php composer.phar global require hirak/prestissimo && php composer.phar install -n --prefer-dist -o
	lastExiteCode=$?
	if [ "$lastExiteCode" != "0" ]; then exit $lastExiteCode; fi;
fi;
mkdir -p /run/nginx
nginx
php-fpm