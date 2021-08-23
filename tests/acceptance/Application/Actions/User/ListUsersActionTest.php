<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\AcceptanceTest\Application\Actions\User;

use DI\Container;
use Kartenmacherei\ApiQaChallenge\AcceptanceTest\TestCase;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use Kartenmacherei\ApiQaChallenge\Domain\User\User;
use Kartenmacherei\ApiQaChallenge\Domain\User\UserRepository;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\User\ListUsersAction */
class ListUsersActionTest extends TestCase
{

    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new User(1, 'bill.gates', 'Bill', 'Gates');

        $userRepositoryProphecy = $this->prophesize(UserRepository::class);
        $userRepositoryProphecy
            ->findAll()
            ->willReturn([$user])
            ->shouldBeCalledOnce();

        $container->set(UserRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/users');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$user]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
