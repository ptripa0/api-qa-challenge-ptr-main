<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Actions\Product;

use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductNotFoundException;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Psr\Http\Message\ResponseInterface as Response;

class ViewProductAction extends ProductAction
{
    protected function action(): Response
    {
        $sku = new Sku($this->resolveArg('sku'));
        $product = $this->productRepository->findProductOfSku($sku);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $this->logger->info(sprintf('Product with SKU %s was viewed.', $sku->asString()));

        return $this->respondWithData($product);
    }
}
