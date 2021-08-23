<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductCollection;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Product\ProductCollection */
class ProductCollectionTest extends TestCase
{
    public function testAddToCollection(): void
    {
        $productCollection = new ProductCollection();

        $this->assertCount(0, $productCollection);

        $productCollection->add(
            new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'))
        );

        $this->assertCount(1, $productCollection);
    }

    public function testFindProductOfSku(): void
    {
        $productCollection = new ProductCollection();
        $product = new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'));

        $productCollection->add($product);

        $this->assertEquals($product, $productCollection->findProductOfSku(new Sku('AOL01GG')));
    }

    public function testFindProductOfSkuReturnsFalseIfNotFound(): void
    {
        $productCollection = new ProductCollection();

        $this->assertFalse($productCollection->findProductOfSku(new Sku('AOL01GG')));
    }

    public function testAsArray(): void
    {
        $productCollection = new ProductCollection();
        $product = new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg'));

        $productCollection->add($product);

        $this->assertEquals(['AOL01GG' => $product], $productCollection->asArray());
    }
}
