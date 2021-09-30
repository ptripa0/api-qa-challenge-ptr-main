## Technical requirements :
- MacOS or Linux
- Docker
- Terminal
- Git

## Test approach
To create unit and acceptance tests for a php application.
Functional and Security tests are covered.


Software technology stack:
PHP 8.0.9 with PCOV 1.0.9, 
PHPUnit 9.5.6, 
Docker containers, 
GitHub Actions


## How to run the tests
GitHub: On code checkin, github actions pipeline will trigger and test results can be viewed from container logs.

On local machine: By executing PHPUnit tests.

ptripa0@PrabodhPC:/mnt/wsl/docker-desktop-bind-mounts/Ubuntu-18.04/fd746880e277b7d49771fb48113f25e7d8a61dc4f8d805c558ac5009049aa3cc$ docker-compose run --rm api-qa
-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all


## Test results

Tests: 100, Assertions: 143, Failures: 17, Passes: 83

More detailed reports can be viewed from PHPUnit test results and Code coverage reports.

