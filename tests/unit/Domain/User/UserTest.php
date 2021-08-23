<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Domain\User;

use Kartenmacherei\ApiQaChallenge\Domain\User\User;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Domain\User\User */
class UserTest extends TestCase
{
    /**
     * @dataProvider userProvider
     */
    public function testGetters(int $id, string $username, string $firstName, string $lastName): void
    {
        $user = new User($id, $username, $firstName, $lastName);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
    }

    /**
     * @dataProvider userProvider
     */
    public function testJsonSerialize(int $id, string $username, string $firstName, string $lastName): void
    {
        $user = new User($id, $username, $firstName, $lastName);

        $expectedPayload = json_encode([
            'id' => $id,
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }

    public function userProvider(): array
    {
        return [
            [1, 'bill.gates', 'Bill', 'Gates'],
            [2, 'steve.jobs', 'Steve', 'Jobs'],
            [3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'],
            [4, 'evan.spiegel', 'Evan', 'Spiegel'],
            [5, 'jack.dorsey', 'Jack', 'Dorsey'],
        ];
    }
}
