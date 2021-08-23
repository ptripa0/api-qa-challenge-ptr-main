<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\User;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
