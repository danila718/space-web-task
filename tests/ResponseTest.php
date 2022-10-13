<?php

use Danila718\SpaceWebTask\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testHasError()
    {
        $errorData = [
            'error' => [
                'code' => 1,
                'message' => 'Error',
            ],
        ];
        $response = new Response($errorData);
        $this->assertTrue($response->hasError());
        $this->assertSame($errorData['error'], $response->getError());
        $this->assertSame($errorData['error']['code'], $response->getErrorCode());
        $this->assertSame($errorData['error']['message'], $response->getErrorMessage());
    }

    public function testEmptyResponse()
    {
        $response = new Response();

        $this->assertTrue($response->hasError());
        $this->assertSame('Empty response', $response->getErrorMessage());
        $this->assertNull($response->getErrorCode());
    }

    public function testCustomErrorMessage()
    {
        $errorMsg = 'Custom error message';
        $response = new Response(null, $errorMsg);

        $this->assertTrue($response->hasError());
        $this->assertSame($errorMsg, $response->getErrorMessage());
        $this->assertNull($response->getErrorCode());
    }

    public function testSuccessResponse()
    {
        $successData = ['result' => 'result'];
        $response = new Response($successData);
        $this->assertFalse($response->hasError());
        $this->assertSame($successData['result'], $response->getResult());
        $this->assertSame($successData, $response->getData());
        $this->assertNull($response->getError());
        $this->assertNull($response->getErrorCode());
        $this->assertNull($response->getErrorMessage());
    }
}
