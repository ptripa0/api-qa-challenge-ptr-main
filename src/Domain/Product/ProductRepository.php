<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    public function findProductOfSku(Sku $sku): Product | false;

    public function addProduct(Product $product): void;
}
