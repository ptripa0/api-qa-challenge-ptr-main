# API QA Challenge: Test Plan
-----------------------------

## Technical requirements :computer:
- MacOS ⌘ or Linux :penguin:
- Docker :whale2:
- Terminal :tv:
- Git :octocat:

## Test approach
Existing testing mechanism is reused to create more unit and acceptance tests.

Software technology stack:
PHP 8.0.9 with PCOV 1.0.9
PHPUnit 9.5.6
Docker containers
GitHub Actions

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
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "!@#$%^&*()_+-=.,\/ is not a valid name"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "!@#$%^&*()_+-=.,\/",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

2) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
6 (array(array('AAAAAAA', '-000000000000000000000000000', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '-000000000000000000000000000 ...d name'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "-000000000000000000000000000 is not a valid name"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "-000000000000000000000000000",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

3) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
7 (array(array('AAAAAAA', '', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '  is not a valid name'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "  is not a valid name"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

4) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
8 (array(array('AAAAAAA', 'null', 10.0), array(Slim\Psr7\UploadedFile Object (...)), 'null is not a valid name'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "null is not a valid name"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "null",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

5) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
9 (array(array('AAAAAAA', '{\n                          ...     }', 10.0), array(Slim\Psr7\UploadedFile Object (...)), '{"statusCode": 200} is not a ...d name'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "{\"statusCode\": 200} is not a valid name"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "{\n                                        \"statusCode\": 200\n                                   }",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

6) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
11 (array(array('AAAAAAA', 'product 1', '6'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 6, is not a float'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "Invalid \"unitPrice\" 6, is not a float"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 6,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

7) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
12 (array(array('AAAAAAA', 'product 1', '-11.50'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" -11.50, i... float'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "Invalid \"unitPrice\" -11.50, is not a float"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": -11.5,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

8) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
13 (array(array('AAAAAAA', 'product 1', '0.000000000001'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 0.000000000001'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "Invalid \"unitPrice\" 0.000000000001"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 1.0e-12,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

9) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set #
14 (array(array('AAAAAAA', 'product 1', '999999999999999'), array(Slim\Psr7\UploadedFile Object (...)), 'Invalid "unitPrice" 999999999999999'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "Invalid \"unitPrice\" 999999999999999"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 999999999999999,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

10) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#15 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg is not a valid image'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "product1.jpg is not a valid image"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 12.5,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

11) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#16 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg is not a valid image'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "product1.jpg is not a valid image"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 12.5,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

12) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#17 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.txt is not a valid image'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "product1.txt is not a valid image"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 12.5,\n
+        "mainImagePath": "product1.txt"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

13) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#18 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.jpg.txt.exe is not a... image'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "product1.jpg.txt.exe is not a valid image"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 12.5,\n
+        "mainImagePath": "product1.jpg.txt.exe"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

14) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsBadRequestIfParametersAreInvalid with data set
#19 (array(array('AAAAAAA', 'product 1', '12.50'), array(Slim\Psr7\UploadedFile Object (...)), 'product1.sh is not a valid image'))
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 400,\n
-    "error": {\n
-        "type": "BAD_REQUEST",\n
-        "description": "product1.sh is not a valid image"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AAAAAAA",\n
+        "name": "product 1",\n
+        "unitPrice": 12.5,\n
+        "mainImagePath": "product1.sh"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:110

15) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testAuthenticateUser
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 401,\n
-    "error": {\n
-        "type": "UNAUTHENTICATED",\n
-        "description": "UNAUTHENTICATED"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "AOL01PP",\n
+        "name": "product 1",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:178

16) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\AddProductActionTest::testActionReturnsConflictIfProductAlreadyExistsWithTheSameSkuDif
ferentCase
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 409,\n
-    "error": {\n
-        "type": "CONFLICT",\n
-        "description": "A product with sku aol01gg already exists"\n
+    "statusCode": 200,\n
+    "data": {\n
+        "sku": "aol01gg",\n
+        "name": "product 1",\n
+        "unitPrice": 10,\n
+        "mainImagePath": "product1.jpg"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/AddProductActionTest.php:213

17) Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product\ViewProductActionTest::testActionReturnsResourceNotFoundResponseIfInvalidProduct
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 '{\n
-    "statusCode": 404,\n
+    "statusCode": 500,\n
     "error": {\n
-        "type": "RESOURCE_NOT_FOUND",\n
-        "description": "The product you requested does not exist."\n
+        "type": "SERVER_ERROR",\n
+        "description": "AOL01G is not a valid sku"\n
     }\n
 }'

/var/www/tests/acceptance/Application/Actions/Product/ViewProductActionTest.php:108

FAILURES!
Tests: 100, Assertions: 143, Failures: 17.


