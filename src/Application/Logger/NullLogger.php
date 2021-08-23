<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Logger;

use Monolog\Handler\NullHandler;
use Monolog\Logger;

class NullLogger extends Logger
{
    public function __construct(string $name, array $handlers = [], array $processors = [])
    {
        $handlers[] = new NullHandler();
        parent::__construct($name, $handlers, $processors);
    }
}
