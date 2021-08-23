<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem;

interface Path
{
    public function asString(): string;
}
