<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice */
class UnitPriceTest extends TestCase
{
    public function testCanGetValueAsString(): void
    {
        $price = 10.00;

        $productName = new UnitPrice($price);

        $this->assertEquals($price, $productName->asFloat());
    }
}
