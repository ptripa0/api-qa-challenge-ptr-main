.PHONY:up stop test unit-test cs

up: vendor
	docker-compose up -d

test:
	docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all

unit-test:
	docker-compose run --rm api-qa-challenge-application vendor/bin/phpunit --testsuite unit

cs:
	docker run --rm -v $(CURDIR):/var/www:rw 047136756731.dkr.ecr.eu-central-1.amazonaws.com/kam-cs:4.0.4

vendor:
	docker run --rm --interactive --tty --volume ${PWD}:/app:rw composer install

stop:
	docker-compose stop
