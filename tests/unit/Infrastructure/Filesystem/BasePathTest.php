<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Infrastructure\Filesystem;

use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath */
class BasePathTest extends TestCase
{
    public function testCanGetValueAsString(): void
    {
        $string = '/path/to/something.ext';
        $basePath = new BasePath($string);

        $this->assertEquals($string, $basePath->asString());
    }

}
