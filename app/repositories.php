<?php

declare(strict_types=1);

use function DI\autowire;
use DI\ContainerBuilder;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Kartenmacherei\ApiQaChallenge\Domain\User\UserRepository;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\Product\InMemoryProductRepository;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\User\InMemoryUserRepository;

return function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        UserRepository::class => autowire(InMemoryUserRepository::class),
        ProductRepository::class => autowire(InMemoryProductRepository::class),
    ]);
};
