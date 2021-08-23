<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

use Exception;
use IteratorAggregate;

class ProductCollection implements IteratorAggregate
{
    private array $products = [];

    public function add(Product $product): void
    {
        $this->products[$product->getSku()->asString()] = $product;
    }

    public function getIterator(): iterable
    {
        yield from $this->products;
    }

    public function findProductOfSku(Sku $sku): Product | false
    {
        try {
            return $this->products[$sku->asString()];
        } catch (Exception) {
            return false;
        }
    }

    public function asArray(): array
    {
        return $this->products;
    }
}
