<?php

namespace SSitdikov\ATOL\Tests;

use SSitdikov\ATOL\Exception\ErrorAuthBadRequestException;
use SSitdikov\ATOL\Exception\ErrorAuthGenTokenException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use PHPUnit\Framework\TestCase;

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
            \json_decode('{"code": 0, "text": null, "token": "' . self::TOKEN . '"}'),
            \json_decode('{"code": 1, "text": null, "token": "' . self::TOKEN . '"}'),
            \json_decode('{"code": 17, "text": "", "token": ""}'),
            \json_decode('{"code": 18, "text": "", "token": ""}'),
            \json_decode('{"code": 19, "text": "", "token": ""}'),
            \json_decode('{"code": 404, "text": "", "token": ""}'),
        ];
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
            $this->request->getResponse($this->responses[0])->getCode(),
            0
        );
        $this->assertEquals(
            '',
            $this->request->getResponse($this->responses[0])->getText()
        );
        $this->assertEquals(
            $this->request->getResponse($this->responses[1])->getToken(),
            self::TOKEN
        );
        $this->assertEquals(
            $this->request->getResponse($this->responses[1])->getCode(),
            1
        );
        $this->assertEquals(
            '',
            $this->request->getResponse($this->responses[1])->getText()
        );
    }

    /**
     * @test
     */
    public function getExceptionErrorAuthBadRequest()
    {
        $this->expectException(ErrorAuthBadRequestException::class);
        $this->request->getResponse($this->responses[2]);
    }

    /**
     * @test
     */
    public function getExceptionAuthGenToken()
    {
        $this->expectException(ErrorAuthGenTokenException::class);
        $this->request->getResponse($this->responses[3]);
    }

    /**
     * @test
     */
    public function getExceptionAuthWrongUserOrPassword()
    {
        $this->expectException(ErrorAuthWrongUserOrPasswordException::class);
        $this->request->getResponse($this->responses[4]);
    }

    /**
     * @test
     */
    public function getException()
    {
        $this->expectException(\Exception::class);
        $this->request->getResponse($this->responses[5]);
    }
}
