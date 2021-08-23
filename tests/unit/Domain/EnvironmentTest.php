<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\InvalidEnvironmentException;
use Kartenmacherei\ApiQaChallenge\Domain\Environment;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\Environment */
class EnvironmentTest extends TestCase
{
    public function testThrowsExceptionIfEnvironmentIsNotValid(): void
    {
        $this->expectException(InvalidEnvironmentException::class);

        new Environment('foo');
    }

    public function testCanReturnAsString(): void
    {
        $env = 'dev';
        $environment = new Environment($env);
        $this->assertEquals($env, $environment->asString());
    }

    public function testEnvironmentIsTest(): void
    {
        $environment = new Environment('test');
        $this->assertTrue($environment->isTest());
    }

    public function testEnvironmentIsNotTest(): void
    {
        $environment = new Environment('dev');
        $this->assertFalse($environment->isTest());
    }

    public function testEnvironmentIsStage(): void
    {
        $environment = new Environment('stage');
        $this->assertTrue($environment->isStage());
    }

    public function testEnvironmentIsNotStage(): void
    {
        $environment = new Environment('dev');
        $this->assertFalse($environment->isStage());
    }

    public function testEnvironmentIsProduction(): void
    {
        $environment = new Environment('prod');
        $this->assertTrue($environment->isProd());
    }

    public function testEnvironmentIsNotProduction(): void
    {
        $environment = new Environment('dev');
        $this->assertFalse($environment->isProd());
    }
}
