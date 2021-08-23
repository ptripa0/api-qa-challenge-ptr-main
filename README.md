# API QA Challenge: Test Plan
-----------------------------
Thanks for sharing the qa api challenge of given e-commerce application.

## Technical requirements :computer:
- MacOS ⌘ or Linux :penguin:
- Docker :whale2:
- Terminal :tv:
- Git :octocat:

## Test approach
Existing testing mechanism is reused to create more unit and acceptance tests.
Functional and Security tests were covered. There is less scope of performance testing for in memory data applications.
Unit and System test levels were covered.

Software technology stack:
PHP 8.0.9 with PCOV 1.0.9, 
PHPUnit 9.5.6, 
Docker containers (PHP, Composer), 
GitHub Actions

Another approach could be to use behat BDD framework for API testing. Also, for better reporting, plugins can be used.
Metadata import from HitHub Actions container can also be implemented as a better way to analyse test results.

## How to run the tests
GitHub: On code checkin, github actions pipeline will trigger and test results can be viewed from container logs.

On local machine: By executing PHPUnit tests.

ptripa0@PrabodhPC:/mnt/wsl/docker-desktop-bind-mounts/Ubuntu-18.04/fd746880e277b7d49771fb48113f25e7d8a61dc4f8d805c558ac5009049aa3cc$ docker-compose run --rm api-qa
-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all

## Test results

Tests: 100, Assertions: 143, Failures: 17, Passes: 83

Please find the bug list as follows:

ptripa0@PrabodhPC:/mnt/wsl/docker-desktop-bind-mounts/Ubuntu-18.04/fd746880e277b7d49771fb48113f25e7d8a61dc4f8d805c558ac5009049aa3cc$ docker-compose run --rm api-qa
-challenge-application vendor/bin/phpunit --coverage-html coverage --testsuite all

There were 17 failures:

1) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
5 (array(array('AAAAAAA', '!@#$%^&*()_+-=.,/', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '!@#$%^&*()_+-=.,/ is not a valid name'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

2) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
6 (array(array('AAAAAAA', '-000000000000000000000000000', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '-000000000000000000000000000 ...d name'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

3) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
7 (array(array('AAAAAAA', '', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '  is not a valid name'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

4) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
8 (array(array('AAAAAAA', 'null', 10.0), array(Slim\Psr7\UploadedFile Object (...)), 'null is not a valid name'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

5) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
9 (array(array('AAAAAAA', '{\n                          ...     }', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '{"statusCode": 200} is not a ...d name'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

6) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
11 (array(array('AAAAAAA', 'product 1', '6'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 6, is not a float'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

7) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
12 (array(array('AAAAAAA', 'product 1', '-11.50'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" -11.50, i... float'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

8) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
13 (array(array('AAAAAAA', 'product 1', '0.000000000001'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 0.000000000001'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

9) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
14 (array(array('AAAAAAA', 'product 1', '999999999999999'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 999999999999999'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

10) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#15 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg is not a valid image'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

11) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#16 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg is not a valid image'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

12) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#17 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.txt is not a valid image'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

13) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#18 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg.txt.exe is not a... image'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

14) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#19 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.sh is not a valid image'))
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

15) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testAuthenticateUser
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:178

16) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsConflictIfProductAlreadyExistsWithTheSameSkuDif
ferentCase
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:213

17) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\ViewProductActionTest::testActionReturnsResourceNotFoundResponseIfInvalidProduct
Failed asserting that two strings are equal.

/var/www/tests/acceptance/Application/Actions/Product/ViewProductActionTest.php:108

FAILURES!
Tests: 100, Assertions: 143, Failures: 17.

More detailed reports can be viewed from PHPUnit test results and Code coverage reports.

Thanks
