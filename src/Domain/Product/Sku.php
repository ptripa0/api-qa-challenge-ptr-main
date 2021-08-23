<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\InvalidSkuException;

class Sku
{
    const SKU_PATTERN = '/^[A-z0-9]{7}$/';

    private string $sku;

    public function __construct($sku)
    {
        $this->validate($sku);
        $this->sku = $sku;
    }

    public function asString(): string
    {
        return $this->sku;
    }

    /**
     * @throws InvalidSkuException
     */
    private function validate(string $value): void
    {
        if (preg_match(self::SKU_PATTERN, $value) !== 1) {
            throw new InvalidSkuException(sprintf('%s is not a valid sku', $value));
        }
    }
}
