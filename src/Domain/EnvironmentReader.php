<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\EnvironmentVariableNotFoundException;

final class EnvironmentReader
{
    public function getEnvironment(): Environment
    {
        return new Environment($this->readFromEnvironment('ENVIRONMENT'));
    }

    public function getLogLevel(): string
    {
        return $this->readFromEnvironment('LOG_LEVEL');
    }

    public function getApplicationName(): string
    {
        return $this->readFromEnvironment('APPLICATION_NAME');
    }

    private function readFromEnvironment(string $key): string
    {
        $envVariable = getenv($key);
        if ($envVariable === false) {
            throw new EnvironmentVariableNotFoundException(
                sprintf('The requested environment variable "%s" was not found', $key)
            );
        }

        return $envVariable;
    }
}
