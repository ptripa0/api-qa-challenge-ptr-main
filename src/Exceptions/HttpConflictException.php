<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpConflictException extends HttpSpecializedException
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = 'Conflict.';

    protected $title = '409 Conflict';

    protected $description = 'The request conflicts with the current state of the server.';
}
