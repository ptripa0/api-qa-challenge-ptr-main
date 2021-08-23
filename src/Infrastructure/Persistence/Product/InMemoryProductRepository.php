<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductCollection;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;

class InMemoryProductRepository implements ProductRepository
{
    private ?ProductCollection $productCollection;

    public function __construct(?ProductCollection $productCollection = null)
    {
        $this->productCollection = $productCollection ?? new ProductCollection();

        if (!isset($productCollection)) {
            $this->productCollection->add(new Product(new Sku('AOL01GG'), new ProductName('product 1'), new UnitPrice(10.00), new BasePath('path/to/product1.jpg')));
            $this->productCollection->add(new Product(new Sku('CEL02HL'), new ProductName('product 2'), new UnitPrice(10.50), new BasePath('path/to/product2.jpg')));
            $this->productCollection->add(new Product(new Sku('KAM11GG'), new ProductName('product 3'), new UnitPrice(15.00), new BasePath('path/to/product3.jpg')));
            $this->productCollection->add(new Product(new Sku('KAM16GG'), new ProductName('product 4'), new UnitPrice(10.00), new BasePath('path/to/product4.jpg')));
            $this->productCollection->add(new Product(new Sku('TEO17TK'), new ProductName('product 5'), new UnitPrice(12.00), new BasePath('path/to/product5.jpg')));
        }
    }

    public function findAll(): array
    {
        return array_values($this->productCollection->asArray());
    }

    public function findProductOfSku(Sku $sku): Product | false
    {
        return $this->productCollection->findProductOfSku($sku);
    }

    public function addProduct(Product $product): void
    {
        $this->productCollection->add($product);
    }
}
