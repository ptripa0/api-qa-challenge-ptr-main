<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem;

class BasePath implements Path
{
    private string $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function asString(): string
    {
        return $this->path;
    }
}
