<?php

declare(strict_types=1);

use Kartenmacherei\ApiQaChallenge\Application\Actions\Product\AddProductAction;
use Kartenmacherei\ApiQaChallenge\Application\Actions\Product\ListProductsAction;
use Kartenmacherei\ApiQaChallenge\Application\Actions\Product\ViewProductAction;
use Kartenmacherei\ApiQaChallenge\Application\Actions\User\ListUsersAction;
use Kartenmacherei\ApiQaChallenge\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app): void {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');

        return $response;
    });

    $app->group('/users', function (Group $group): void {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/products', function (Group $group): void {
        $group->get('', ListProductsAction::class);
        $group->get('/{sku}', ViewProductAction::class);
        $group->post('', AddProductAction::class);
    });
};
