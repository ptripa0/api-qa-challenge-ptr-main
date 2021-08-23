FROM php:8-alpine

RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov

WORKDIR /var/www

ENTRYPOINT ["/var/www", "/makefile"]
RUN ["chmod", "+x", "/var/www/makefile"]
