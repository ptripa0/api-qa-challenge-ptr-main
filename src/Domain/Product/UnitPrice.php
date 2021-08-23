<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

class UnitPrice
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function asFloat(): float
    {
        return $this->value;
    }
}
