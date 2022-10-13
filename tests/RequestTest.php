<?php

use Danila718\SpaceWebTask\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testUrl()
    {
        $request = new Request();
        $url = 'https://example.com/';
        $request->setUrl($url);

        $this->assertNotEmpty($request->getUrl());
        $this->assertSame($url, $request->getUrl());
    }

    public function testHeaders()
    {
        $request = new Request();
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $request->setHeaders($headers);

        $this->assertNotEmpty($request->getHeaders());
        $this->assertSame($headers, $request->getHeaders());
    }

    public function testBody()
    {
        $request = new Request();
        $body = [
            'method' => 'getToken',
            'params' => [
                'param1' => 'value'
            ]
        ];
        $request->setBody($body);

        $this->assertNotEmpty($request->getBody());
        $this->assertSame($body, $request->getBody());
    }

    public function testPost()
    {
        $request = new Request();
        $data = [
            'method' => 'getToken',
            'params' => [
                'param1' => 'value'
            ]
        ];
        $request->post($data);

        $this->assertSame('post', strtolower($request->getMethod()));
        $this->assertNotEmpty($request->getBody());
        $this->assertSame($data, $request->getBody());
    }
}
