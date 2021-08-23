<?php

declare(strict_types=1);

use Kartenmacherei\ApiQaChallenge\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app): void {
    $app->add(SessionMiddleware::class);
};
