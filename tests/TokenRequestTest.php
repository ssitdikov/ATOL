<?php

namespace SSitdikov\ATOL\Tests;

use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use function json_decode;

class TokenRequestTest extends TestCase
{

    const TOKEN = 'd41d8cd98f00b204e9800998ecf8427e';

    /**
     * @var TokenRequest
     */
    private $request;
    private $responses = [];

    public function setUp()
    {
        $this->request = new TokenRequest('login', 'password');
        $this->responses = [
            json_decode('{"error": null, "timestamp": "", "token": "' . self::TOKEN . '"}'),
            json_decode('{"error": null, "timestamp": "", "token": "' . self::TOKEN . '"}'),
            json_decode('{"error": 17, "timestamp": "", "token": ""}'),
            json_decode('{"error": 18, "timestamp": "", "token": ""}'),
            json_decode('{"error": 19, "timestamp": "", "token": ""}'),
            json_decode('{"error": 404, "timestamp": "", "token": ""}'),
        ];
    }

    /**
     * @test
     */
    public function getMethod()
    {
        $this->assertEquals(RequestInterface::METHOD_POST, $this->request->getMethod());
    }

    /**
     * @test
     */
    public function getParams()
    {
        $this->assertEquals([
            'json' => [
                'login' => 'login',
                'pass'  => 'password',
            ],
        ], $this->request->getParams());
    }

    /**
     * @test
     */
    public function getUrl()
    {
        $this->assertEquals('getToken/', $this->request->getUrl());
    }

    /**
     * @test
     */
    public function getResponse()
    {
        $this->assertEquals(
            $this->request->getResponse($this->responses[0])->getToken(),
            self::TOKEN
        );
        $this->assertEquals(
            $this->request->getResponse($this->responses[1])->getToken(),
            self::TOKEN
        );
    }
}
