FROM php:8-alpine

RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov

WORKDIR /var/www
RUN echo $pwd
ENTRYPOINT ["/Makefile"]
RUN ["echo $PWD"]
RUN echo $pwd
