<?php

namespace SSitdikov\ATOL\Tests;

use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use PHPUnit\Framework\TestCase;

class TokenRequestTest extends TestCase
{

    /**
     * @var TokenRequest
     */
    private $request;

    public function setUp()
    {
        $this->request = new TokenRequest('login', 'password');
    }

    /**
     * @test
     */
    public function getMethod()
    {
        $this->assertEquals(RequestInterface::POST, $this->request->getMethod());
    }

    /**
     * @test
     */
    public function getParams()
    {
        $this->assertEquals(['json' => [
            'login' => 'login',
            'pass' => 'password',
        ]], $this->request->getParams());
    }

    /**
     * @test
     */
    public function getUrl()
    {
        $this->assertEquals('getToken/', $this->request->getUrl());
    }
}
