<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Kartenmacherei\ApiQaChallenge\Application\Settings\Settings;
use Kartenmacherei\ApiQaChallenge\Application\Settings\SettingsInterface;
use Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader;

return function (ContainerBuilder $containerBuilder): void {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function (EnvironmentReader $environmentReader) {
            return new Settings([
                'displayErrorDetails' => !($environmentReader->getEnvironment()->isProd() || $environmentReader->getEnvironment()->isStage()),
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => $environmentReader->getApplicationName(),
                    'level' => $environmentReader->getLogLevel(),
                    'path' => 'php://stdout',
                ],
            ]);
        },
    ]);
};
