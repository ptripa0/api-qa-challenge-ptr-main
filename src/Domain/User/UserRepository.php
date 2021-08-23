<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;
}
