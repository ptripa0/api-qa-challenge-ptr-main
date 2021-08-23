<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\InvalidEnvironmentException;

final class Environment
{
    private const DEV_ENV = 'dev';
    private const TEST_ENV = 'test';
    private const PROD_ENV = 'prod';
    private const STAGE_ENV = 'stage';
    private const VALID_ENVIRONMENTS = [self::DEV_ENV, self::TEST_ENV, self::STAGE_ENV, self::PROD_ENV];

    private string $value;

    public function __construct(string $environment)
    {
        $this->ensure($environment);
        $this->value = $environment;
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function isTest(): bool
    {
        return $this->value === self::TEST_ENV;
    }

    public function isProd(): bool
    {
        return $this->value === self::PROD_ENV;
    }

    public function isStage(): bool
    {
        return $this->value === self::STAGE_ENV;
    }

    private function ensure(string $environment): void
    {
        if (!in_array($environment, self::VALID_ENVIRONMENTS, true)) {
            throw new InvalidEnvironmentException(
                sprintf('Invalid environment given: [%s]', $environment)
            );
        }
    }
}
