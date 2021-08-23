<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

class ConsoleLogger extends Logger
{
    public function __construct(string $name, string $path, $logLevel = Logger::INFO, array $handlers = [], array $processors = [])
    {
        $processors[] = new UidProcessor();
        $handlers[] = new StreamHandler($path, $logLevel);

        parent::__construct($name, $handlers, $processors);
    }
}
