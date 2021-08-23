<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\Path;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Product\Product */
class ProductTest extends TestCase
{
    /**
     * @dataProvider productProvider
     */
    public function testGetters(Sku $sku, ProductName $name, UnitPrice $unitPrice, Path $mainImagePath): void
    {
        $product = new Product($sku, $name, $unitPrice, $mainImagePath);

        $this->assertEquals($sku, $product->getSku());
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($unitPrice, $product->getUnitPrice());
        $this->assertEquals($mainImagePath, $product->getMainImagePath());
    }

    /**
     * @dataProvider productProvider
     */
    public function testJsonSerialize(Sku $sku, ProductName $name, UnitPrice $unitPrice, Path $mainImagePath): void
    {
        $product = new Product($sku, $name, $unitPrice, $mainImagePath);

        $expectedPayload = json_encode([
            'sku' => $sku->asString(),
            'name' => $name->asString(),
            'unitPrice' => $unitPrice->asFloat(),
            'mainImagePath' => $mainImagePath->asString(),
        ]);

        $this->assertEquals($expectedPayload, json_encode($product));
    }

    public function productProvider(): array
    {
        return [
            [new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg')],
            [new Sku('CEL02HL'), new ProductName('product 2'), new UnitPrice(10.50), new BasePath('path/to/product2.jpg')],
            [new Sku('KAM11GG'), new ProductName('product 3'), new UnitPrice(15.00), new BasePath('path/to/product3.jpg')],
            [new Sku('KAM16GG'), new ProductName('product 4'), new UnitPrice(10.00), new BasePath('path/to/product4.jpg')],
            [new Sku('TEO17TK'), new ProductName('product 5'), new UnitPrice(12.00), new BasePath('path/to/product5.jpg')],
        ];
    }
}
