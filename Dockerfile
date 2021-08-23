FROM php:8-alpine

RUN rm -R /var/www

RUN apk add build-base autoconf
RUN pecl install pcov && docker-php-ext-enable pcov

RUN mkdir src
RUN echo $pwd
RUN ls
COPY . /src/
RUN ls

WORKDIR /src
RUN echo $pwd
RUN cd /src
ENTRYPOINT ["/Makefile"] ;exit 0
RUN echo $pwd
RUN docker run --rm --interactive --tty --volume ${PWD}:/app:rw composer install
RUN docker-compose up -d

RUN docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all

RUN docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --testsuite unit

RUN docker-compose stop

	

