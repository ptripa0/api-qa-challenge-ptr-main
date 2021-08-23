<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product;

use Kartenmacherei\ApiQaChallenge\AcceptanceTest\TestCase;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Application\Handlers\HttpErrorHandler;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\UploadedFile;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\Product\AddProductAction */
class AddProductActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        $product = new Product(new Sku('AAAAAAA'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('product1.jpg'));

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody([
            'sku' => 'AAAAAAA',
            'name' => 'product 1',
            'unitPrice' => 10.00,
        ]);

        $request = $request->withUploadedFiles([
            'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
        ]);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $product);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    /**
     * @dataProvider getDataWithMissingParameters
     *
     * @param mixed $testData
     */
    public function testActionReturnsBadRequestIfMissingParameters($testData): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody($testData['parsedBody']);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(
            ActionError::BAD_REQUEST,
            sprintf('The form is missing the parameter "%s"', $testData['missingParameter'])
        );
        $expectedPayload = new ActionPayload(400, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    /**
     * @dataProvider getDataWithBadParameters
     *
     * @param mixed $testData
     */
    public function testActionReturnsBadRequestIfParametersAreInvalid($testData): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody($testData['parsedBody']);
        $request = $request->withUploadedFiles($testData['mainImage']);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::BAD_REQUEST, $testData['errorMessage']);
        $expectedPayload = new ActionPayload(400, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionReturnsConflictIfProductAlreadyExistsWithTheSameSku(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody([
            'sku' => 'KAM11GG',
            'name' => 'product 1',
            'unitPrice' => 10.00,
        ]);

        $request = $request->withUploadedFiles([
            'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
        ]);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::CONFLICT, 'A product with sku KAM11GG already exists');
        $expectedPayload = new ActionPayload(409, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testAuthenticateUser(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody([
            'sku' => 'AOL01PP',
            'name' => 'product 1',
            'unitPrice' => 10.00,
        ]);

        $request = $request->withUploadedFiles([
            'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
        ]);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::UNAUTHENTICATED, 'UNAUTHENTICATED');
        $expectedPayload = new ActionPayload(401, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }


    public function testActionReturnsConflictIfProductAlreadyExistsWithTheSameSkuDifferentCase(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody([
            'sku' => 'aol01gg',
            'name' => 'product 1',
            'unitPrice' => 10.00,
        ]);

        $request = $request->withUploadedFiles([
            'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
        ]);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::CONFLICT, 'A product with sku aol01gg already exists');
        $expectedPayload = new ActionPayload(409, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }



    public function testActionReturnsBadRequestIfImageCouldNotBeUploaded(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        $request = $this->createRequest('POST', '/products');
        $request = $request->withParsedBody([
            'sku' => 'KAM11GG',
            'name' => 'product 1',
            'unitPrice' => 10.00,
        ]);

        $uploadedFileProphecy = $this->prophesize(UploadedFile::class);
        $uploadedFileProphecy
            ->getError()
            ->willReturn(UPLOAD_ERR_CANT_WRITE)
            ->shouldBeCalledOnce();

        $request = $request->withUploadedFiles([
            'mainImage' => $uploadedFileProphecy->reveal(),
        ]);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::SERVER_ERROR, 'Image could not be uploaded');
        $expectedPayload = new ActionPayload(500, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function getDataWithMissingParameters(): array
    {
        return [
            [
                'missing-sku' => [
                    'missingParameter' => 'sku',
                    'parsedBody' => [
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ]
                ],
            ],
            [
                'missing-name' => [
                    'missingParameter' => 'name',
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ]
                ],
            ],
            [
                'missing-unitPrice' => [
                    'missingParameter' => 'unitPrice',
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => 'product 1',
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ]
                ],
            ],
            [
                'missing-mainImage' => [
                    'missingParameter' => 'mainImage',
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                ],
            ],
        ];
    }

    public function getDataWithBadParameters(): array
    {
        return [
            [
                'bad-sku' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAAB',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => 'AAAAAAAB is not a valid sku',
                ],
            ],
            [
                'bad-sku' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAA',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => 'AAAAAA is not a valid sku',
                ],
            ],
            [
                'bad-sku' => [
                    'parsedBody' => [
                        'sku' => '12345',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '12345 is not a valid sku',
                ],
            ],
            [
                'bad-sku' => [
                    'parsedBody' => [
                        'sku' => '-10.50',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '-10.50 is not a valid sku',
                ],
            ],
            [
                'bad-sku' => [
                    'parsedBody' => [
                        'sku' => '!@#$%^,',
                        'name' => 'product 1',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '!@#$%^, is not a valid sku',
                ],
            ],
         
            [
                'bad-name' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => '!@#$%^&*()_+-=.,/',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '!@#$%^&*()_+-=.,/ is not a valid name',
                ],
            ],
            [
                'bad-name' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => '-000000000000000000000000000',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '-000000000000000000000000000 is not a valid name',
                ],
            ],
            [
                'bad-name' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => '',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '  is not a valid name',
                ],
            ],
            [
                'bad-name' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => 'null',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => 'null is not a valid name',
                ],
            ],

            [
                'bad-name' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => '{
                                        "statusCode": 200
                                   }',
                        'unitPrice' => 10.00,
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => '{"statusCode": 200} is not a valid name',
                ],
            ],

            ['bad-unit-price' => [
                    'parsedBody' => [
                        'sku' => 'AAAAAAA',
                        'name' => 'product 1',
                        'unitPrice' => 'a10.00',
                    ],
                    'mainImage' => [
                        'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                    ],
                    'errorMessage' => 'Invalid "unitPrice" a10.00, is not a float',
                ],
            ],
            ['bad-unit-price' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '6',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                ],
                'errorMessage' => 'Invalid "unitPrice" 6, is not a float',
            ],
            ],
            ['bad-unit-price' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '-11.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                ],
                'errorMessage' => 'Invalid "unitPrice" -11.50, is not a float',
            ],
            ],
            ['bad-unit-price' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '0.000000000001',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                ],
                'errorMessage' => 'Invalid "unitPrice" 0.000000000001',
            ],
            ],
            ['bad-unit-price' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '999999999999999',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 1),
                ],
                'errorMessage' => 'Invalid "unitPrice" 999999999999999',
            ],
            ],
            ['bad-mainImage' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '12.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 0),
                ],
                'errorMessage' => 'product1.jpg is not a valid image',
            ],
            ],

            ['bad-mainImage' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '12.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg', 'image/jpg', 99999999999999),
                ],
                'errorMessage' => 'product1.jpg is not a valid image',
            ],
            ],

            ['bad-mainImage' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '12.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.txt', 'image/jpg', 9999),
                ],
                'errorMessage' => 'product1.txt is not a valid image',
            ],
            ],

            ['bad-mainImage' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '12.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.jpg.txt.exe', 'image/txt', -1),
                ],
                'errorMessage' => 'product1.jpg.txt.exe is not a valid image',
            ],
            ],

            ['bad-mainImage' => [
                'parsedBody' => [
                    'sku' => 'AAAAAAA',
                    'name' => 'product 1',
                    'unitPrice' => '12.50',
                ],
                'mainImage' => [
                    'mainImage' => new UploadedFile('/path/to/file1', 'product1.sh', 'image/jpg', 9999),
                ],
                'errorMessage' => 'product1.sh is not a valid image',
            ],
            ],
        ];
    }
}
