<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

use JsonSerializable;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\Path;

class Product implements JsonSerializable
{
    private Sku $sku;

    private ProductName $name;

    private UnitPrice $unitPrice;

    private Path $mainImagePath;

    public function __construct(Sku $sku, ProductName $name, UnitPrice $unitPrice, Path $mainImagePath)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->mainImagePath = $mainImagePath;
    }

    public function getSku(): Sku
    {
        return $this->sku;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getUnitPrice(): UnitPrice
    {
        return $this->unitPrice;
    }

    public function getMainImagePath(): Path
    {
        return $this->mainImagePath;
    }

    public function jsonSerialize(): array
    {
        return [
            'sku' => $this->sku->asString(),
            'name' => $this->name->asString(),
            'unitPrice' => $this->unitPrice->asFloat(),
            'mainImagePath' => $this->mainImagePath->asString(),
        ];
    }
}
