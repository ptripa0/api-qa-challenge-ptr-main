<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Actions\Product;

use Kartenmacherei\ApiQaChallenge\Application\Actions\Action;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Psr\Log\LoggerInterface;

abstract class ProductAction extends Action
{
    protected ProductRepository $productRepository;

    public function __construct(LoggerInterface $logger, ProductRepository $productRepository)
    {
        parent::__construct($logger);
        $this->productRepository = $productRepository;
    }
}
