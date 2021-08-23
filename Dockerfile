FROM php:8-alpine

RUN rm -R /var/www
RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov

WORKDIR /var/www
RUN echo $pwd
RUN cd /var/www
ENTRYPOINT ["/Makefile"] ;exit 0
RUN echo $pwd
RUN ./Makefile

