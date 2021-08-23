FROM php:8-alpine

RUN rm -R /var/www

RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov

RUN mkdir src
RUN pwd
RUN ls
COPY . /src/
RUN ls

WORKDIR /src
RUN pwd
RUN cd /src
RUN pwd
RUN ls
RUN ls -ltr
RUN chmod 776 Makefile
RUN ls -ltr
RUN chmod 776 docker-compose.yml
RUN chmod 776 phpunit.xml.dist
RUN chmod 776 bootstrap.php
RUN chmod 776 Dockerfile
RUN ls -ltr
ENTRYPOINT ["/Makefile"]
	

