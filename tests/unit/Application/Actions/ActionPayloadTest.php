<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\UnitTest\Application\Actions;

use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionError;
use Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload;
use PHPUnit\Framework\TestCase;

/** @covers \Kartenmacherei\ApiQaChallenge\Application\Actions\ActionPayload */
class ActionPayloadTest extends TestCase
{
    public function testGetters(): void
    {
        $actionPayload = new ActionPayload();

        $this->assertEquals(200, $actionPayload->getStatusCode());
        $this->assertEquals(null, $actionPayload->getData());
        $this->assertEquals(null, $actionPayload->getError());
    }

    public function testCanSerializeToJsonJustTheStatusCode(): void
    {
        $actionPayload = new ActionPayload();

        $this->assertEquals(
            [
                'statusCode' => 200,
            ],
            $actionPayload->jsonSerialize()
        );
    }

    public function testCanSerializeToJsonTheStatusCodeAndTheData(): void
    {
        $actionPayload = new ActionPayload(200, 'test data');

        $this->assertEquals(
            [
                'statusCode' => 200,
                'data' => 'test data',
            ],
            $actionPayload->jsonSerialize()
        );
    }

    public function testCanSerializeToJsonTheStatusCodeAndTheError(): void
    {
        $error = new ActionError(ActionError::SERVER_ERROR, 'Server error');
        $actionPayload = new ActionPayload(
            500,
            null,
            $error
        );

        $this->assertEquals(
            [
                'statusCode' => 500,
                'error' => $error,
            ],
            $actionPayload->jsonSerialize()
        );
    }
}
