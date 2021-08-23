<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use function DI\create;
use Kartenmacherei\ApiQaChallenge\Application\Logger\ConsoleLogger;
use Kartenmacherei\ApiQaChallenge\Application\Logger\NullLogger;
use Kartenmacherei\ApiQaChallenge\Application\Settings\SettingsInterface;
use Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions([
        EnvironmentReader::class => create(EnvironmentReader::class),
        LoggerInterface::class => function (ContainerInterface $c, EnvironmentReader $environmentReader) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');

            if ($environmentReader->getEnvironment()->isTest()) {
                return new NullLogger($loggerSettings['name']);
            }

            return new ConsoleLogger($loggerSettings['name'], $loggerSettings['path'], $loggerSettings['level']);
        },
    ]);
};
