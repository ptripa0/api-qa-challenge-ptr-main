<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product;

use DI\Container;
use Kartenmacherei\ApiQaChallenge\AcceptanceTest\TestCase;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Application\Handlers\HttpErrorHandler;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use Slim\Middleware\ErrorMiddleware;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\Product\ViewProductAction */
class ViewProductActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $product = new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'));

        $productRepositoryProphecy = $this->prophesize(ProductRepository::class);
        $productRepositoryProphecy
            ->findProductOfSku(new Sku('AOL01GG'))
            ->willReturn($product)
            ->shouldBeCalledOnce();

        $container->set(ProductRepository::class, $productRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/products/AOL01GG');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $product);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionReturnsProductNotFoundException(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $productRepositoryProphecy = $this->prophesize(ProductRepository::class);
        $productRepositoryProphecy
            ->findProductOfSku(new Sku('AOL01GG'))
            ->willReturn(false)
            ->shouldBeCalledOnce();

        $container->set(ProductRepository::class, $productRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/products/AOL01GG');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The product you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionReturnsResourceNotFoundResponseIfInvalidProduct(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $request = $this->createRequest('GET', '/products/AOL01G');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The product you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsResourceNotFoundExceptionIfInvalidUrl(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $request = $this->createRequest('GET', '/product/AOL01GG');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'Not found.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

}
