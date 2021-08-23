<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Infrastructure\Persistence\User;

use Kartenmacherei\ApiQaChallenge\Domain\User\User;
use Kartenmacherei\ApiQaChallenge\Domain\User\UserNotFoundException;
use Kartenmacherei\ApiQaChallenge\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    private array $users;

    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new User(1, 'bill.gates', 'Bill', 'Gates'),
            2 => new User(2, 'steve.jobs', 'Steve', 'Jobs'),
            3 => new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
            4 => new User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
            5 => new User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
        ];
    }

    public function findAll(): array
    {
        return array_values($this->users);
    }

    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }
}
