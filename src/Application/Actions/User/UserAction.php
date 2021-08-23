<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Actions\User;

use Kartenmacherei\ApiQaChallenge\Application\Actions\Action;
use Kartenmacherei\ApiQaChallenge\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}
