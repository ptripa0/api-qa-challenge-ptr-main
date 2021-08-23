<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions;

use DateTimeImmutable;
use Kartenmacherei\ApiQaChallenge\AcceptanceTest\TestCase;
use Kartenmacherei\ApiQaChallenge\Application\Actions\Action;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\Action */
class ActionTest extends TestCase
{
    public function testActionSetsHttpCodeInRespond(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respond(
                    new ActionPayload(
                        202,
                        [
                            'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM),
                        ]
                    )
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        $this->assertEquals(202, $response->getStatusCode());
    }

    public function testActionSetsHttpCodeRespondData(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respondWithData(
                    [
                        'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM),
                    ],
                    202
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        $this->assertEquals(202, $response->getStatusCode());
    }

    public function testResolveArgsThrowsExceptionIfParameterIsNotPResent(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                $this->resolveArg('foo');

                return $this->response;
            }
        };

        $this->expectException(HttpBadRequestException::class);

        $app->get('/test-action-args-exception', $testAction);
        $request = $this->createRequest('GET', '/test-action-args-exception');
        $app->handle($request);
    }

    public function testResolveArgs(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respondWithData(
                    [
                        'foo' => $this->resolveArg('foo'),
                    ],
                    202
                );
            }
        };

        $app->get('/test-action-with-args/{foo}', $testAction);
        $request = $this->createRequest('GET', '/test-action-with-args/bar');
        $response = $app->handle($request);

        $this->assertEquals(202, $response->getStatusCode());
        $response->getBody()->rewind();

        $this->assertEquals('bar', json_decode($response->getBody()->getContents())->data->foo);
    }

    public function testThrowsExceptionIfActionThrowsException(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                throw new DomainRecordNotFoundException();
            }
        };

        $this->expectException(HttpNotFoundException::class);

        $app->get('/test-action-not-found', $testAction);
        $request = $this->createRequest('GET', '/test-action-not-found');
        $app->handle($request);
    }



}
