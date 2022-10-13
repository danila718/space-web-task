<?php

use Danila718\SpaceWebTask\Request;
use Danila718\SpaceWebTask\Response;
use Danila718\SpaceWebTask\Services\SpaceWebService;
use PHPUnit\Framework\TestCase;

class SpaceWebServiceTest extends TestCase
{
    protected SpaceWebService $spaceWebService;
    protected $requestMock;

    public function setUp()
    {
        $mockRequest = $this->getMockClass(Request::class);
        $this->requestMock = new $mockRequest;
        $this->spaceWebService = new SpaceWebService($this->requestMock);
    }

    public function testGetTokenWrong()
    {
        $returnData = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => -32400,
                'message' => 'Wrong password',
            ],
        ];
        $this->requestMock->method('send')->willReturn(new Response($returnData));

        $result = $this->spaceWebService->getToken([
            'login' => 'wronLogin',
            'password' => 'wronPassword',
        ]);

        $this->assertNotEmpty($result);
        $this->assertSame($returnData['error']['message'], $result);
    }

    public function testGetTokenSuccess()
    {
        $returnData = [
            'jsonrpc' => '2.0',
            'result' => 'hhe45bqghits04l21mu.ffc1713d',
        ];
        $this->requestMock->method('send')
            ->willReturn(new Response($returnData));
        $result = $this->spaceWebService->getToken([
            'login' => 'successLogin',
            'password' => 'successPassword',
        ]);
        $this->assertNotEmpty($result);
        $this->assertSame($returnData['result'], $result);
    }
}
