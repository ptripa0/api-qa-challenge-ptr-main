<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName */
class ProductNameTest extends TestCase
{
    public function testCanGetValueAsString(): void
    {
        $name = 'foo';

        $productName = new ProductName($name);

        $this->assertEquals($name, $productName->asString());
    }
}
