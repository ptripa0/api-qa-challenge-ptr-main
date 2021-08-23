<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\InvalidSkuException;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Product\Sku */
class SkuTest extends TestCase
{
    public function testCanGetValueAsString(): void
    {
        $string = 'KAM11GG';
        $sku = new Sku($string);

        $this->assertEquals($string, $sku->asString());
    }

    public function testThrowsExceptionIfSkuIsNotValid(): void
    {
        $this->expectException(InvalidSkuException::class);

        new Sku('KAM11GGG');
    }
}
