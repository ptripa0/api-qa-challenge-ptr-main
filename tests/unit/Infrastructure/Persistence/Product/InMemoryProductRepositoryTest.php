<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Infrastructure\Persistance\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductCollection;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\Product\InMemoryProductRepository;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\Product\InMemoryProductRepository */
class InMemoryProductRepositoryTest extends TestCase
{
    public function testFindAll(): void
    {
        $productCollection = new ProductCollection();
        $product = new Product(new Sku('FOO01AA'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('/path/to/image.jpg'));
        $productCollection->add($product);

        $productRepository = new InMemoryProductRepository($productCollection);

        $this->assertEquals([$product], $productRepository->findAll());
    }

    public function testFindAllProductsByDefault(): void
    {
        $products = [
            'AOL01GG' => new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg')),
            'CEL02HL' => new Product(new Sku('CEL02HL'), new ProductName('product 2'), new UnitPrice(10.50), new BasePath('path/to/product2.jpg')),
            'KAM11GG' => new Product(new Sku('KAM11GG'), new ProductName('product 3'), new UnitPrice(15.00), new BasePath('path/to/product3.jpg')),
            'KAM16GG' => new Product(new Sku('KAM16GG'), new ProductName('product 4'), new UnitPrice(10.00), new BasePath('path/to/product4.jpg')),
            'TEO17TK' => new Product(new Sku('TEO17TK'), new ProductName('product 5'), new UnitPrice(12.00), new BasePath('path/to/product5.jpg')),
        ];

        $productRepository = new InMemoryProductRepository();

        $this->assertEquals(array_values($products), $productRepository->findAll());
    }

    public function testFindProductOfSku(): void
    {
        $product = new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'));

        $productRepository = new InMemoryProductRepository();

        $this->assertEquals($product, $productRepository->findProductOfSku(new Sku('AOL01GG')));
    }

    public function testFindProductOfSkuReturnsFalseIfNotFound(): void
    {
        $productCollection = new ProductCollection();
        $productRepository = new InMemoryProductRepository($productCollection);

        $this->assertFalse($productRepository->findProductOfSku(new Sku('AOL01GG')));
    }

    public function testCanAddANewProduct(): void
    {
        $sku = new Sku('AAAAAAA');
        $productCollection = new ProductCollection();
        $productRepository = new InMemoryProductRepository($productCollection);
        $product = new Product(
            $sku,
            new ProductName('product 1'),
            new UnitPrice(10.00),
            new BasePath('image.jpg')
        );

        $productRepository->addProduct($product);

        $this->assertEquals($product, $productRepository->findProductOfSku($sku));
    }
}
