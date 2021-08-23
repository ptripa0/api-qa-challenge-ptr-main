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
ENTRYPOINT ["/Makefile"] ;exit 0
RUN pwd
RUN ls
RUN ls -ltr
RUN chmod 776 Makefile
RUN ls -ltr
RUN docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all

RUN sudo docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --testsuite unit

RUN sudo docker-compose stop

	

