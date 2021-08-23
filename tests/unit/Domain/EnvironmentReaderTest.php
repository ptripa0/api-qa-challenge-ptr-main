<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain;

use Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader */
class EnvironmentReaderTest extends TestCase
{
    private EnvironmentReader $environmentReader;

    public function setUp(): void
    {
        $this->environmentReader = new EnvironmentReader();
    }

    public function testGetEnvironment(): void
    {
        $this->assertTrue($this->environmentReader->getEnvironment()->isTest());
    }

    public function testGetLogLevel(): void
    {
        $this->assertEquals('INFO', $this->environmentReader->getLogLevel());
    }

    public function testGetApplicationName(): void
    {
        $this->assertEquals('api-qa-challenge', $this->environmentReader->getApplicationName());
    }
}
