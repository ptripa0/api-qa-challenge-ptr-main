<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    protected function action(): Response
    {
        $users = $this->userRepository->findAll();

        $this->logger->info('Users list was viewed.');

        return $this->respondWithData($users);
    }
}
