<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Application\Actions;

use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError */
class ActionErrorTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $actionError = new ActionError(ActionError::SERVER_ERROR, null);

        $this->assertEquals(ActionError::SERVER_ERROR, $actionError->getType());

        $actionError->setType(ActionError::BAD_REQUEST);

        $this->assertEquals(ActionError::BAD_REQUEST, $actionError->getType());

        $actionError->setDescription('Description of the error');

        $this->assertEquals('Description of the error', $actionError->getDescription());
    }

    public function testCanSerializeToJson(): void
    {
        $actionError = new ActionError(ActionError::SERVER_ERROR, 'Description of the error');

        $this->assertEquals(
            [
                'type' => ActionError::SERVER_ERROR,
                'description' => 'Description of the error',
            ],
            $actionError->jsonSerialize()
        );
    }
}
