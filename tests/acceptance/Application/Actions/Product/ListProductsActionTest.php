<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\Product;

use DI\Container;
use Kartenmacherei\ApiQaChallenge\AcceptanceTest\TestCase;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\Product\ListProductsAction */
class ListProductsActionTest extends TestCase
{
    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $product = new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'));

        $productRepositoryProphecy = $this->prophesize(ProductRepository::class);
        $productRepositoryProphecy
            ->findAll()
            ->willReturn([$product])
            ->shouldBeCalledOnce();

        $container->set(ProductRepository::class, $productRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/products');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$product]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
