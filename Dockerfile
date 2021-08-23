FROM php:8-alpine


RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov



WORKDIR /var/www
RUN pwd
RUN ls
RUN ls -ltr
RUN chmod 777 Makefile
RUN chmod 776 docker-compose.yml
RUN chmod 776 phpunit.xml.dist
RUN chmod 776 bootstrap.php
RUN chmod 776 Dockerfile
RUN ls -ltr
ENTRYPOINT ["/Makefile"]

