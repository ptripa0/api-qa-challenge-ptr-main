<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application;

use DI\ContainerBuilder;
use Kartenmacherei\ApiQaChallenge\Application\Handlers\HttpErrorHandler;
use Kartenmacherei\ApiQaChallenge\Application\Handlers\ShutdownHandler;
use Kartenmacherei\ApiQaChallenge\Application\Settings\SettingsInterface;
use Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Handlers\Strategies\RequestResponse;

class ApplicationBuilder
{
    public function build(EnvironmentReader $environmentReader): App
    {
        $environment = $environmentReader->getEnvironment();

        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        if ($environment->isProd() || $environment->isStage()) {
            $containerBuilder->enableCompilation(__DIR__ . '/../../var/cache');
        }

        // Set up settings
        $settings = require __DIR__ . '/../../app/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../../app/dependencies.php';
        $dependencies($containerBuilder);

        // Set up repositories
        $repositories = require __DIR__ . '/../../app/repositories.php';
        $repositories($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        $callableResolver = $app->getCallableResolver();

        // Register middleware
        $middleware = require __DIR__ . '/../../app/middleware.php';
        $middleware($app);

        // Register routes
        $routes = require __DIR__ . '/../../app/routes.php';
        $routes($app);

        /** @var SettingsInterface $settings */
        $settings = $container->get(SettingsInterface::class);

        $displayErrorDetails = $settings->get('displayErrorDetails');
        $logError = $settings->get('logError');
        $logErrorDetails = $settings->get('logErrorDetails');

        // Create Request object from globals
        $serverRequestCreator = ServerRequestCreatorFactory::create();
        $request = $serverRequestCreator->createServerRequestFromGlobals();

        // Create Error Handler
        $responseFactory = $app->getResponseFactory();
        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

        // Create Shutdown Handler
        $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
        register_shutdown_function($shutdownHandler);

        // Add Routing Middleware
        $app->addRoutingMiddleware();

        // Add Error Middleware
        $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $routeCollector = $app->getRouteCollector();
        $routeCollector->setDefaultInvocationStrategy(new RequestResponse());

        return $app;
    }
}
