<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.11.17
 * Time: 7:03
 */

namespace SSitdikov\ATOL\Tests;

use SSitdikov\ATOL\Client\ApiClient;
use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class ApiClientTest extends TestCase
{

    private $apiMock;


    public function setUp()
    {
        $this->apiMock = $this->getMockBuilder(ApiClient::class)
            ->getMock();
    }

    /**
     * @test
     */
    public function getTokenRequest()
    {
        $this->apiMock->method('getToken')->willReturn(new TokenResponse(\json_decode(
            '{"code":0, "text":"", "token":"token"}'
        )));

        $request = new TokenRequest('login', 'password');
        /**
         * @var TokenResponse $token
         */
        $token = $this->apiMock->getToken($request);

        $this->assertEquals('token', $token->getToken());
    }

    /**
     * @test
     */
    public function doOperationRequest()
    {
        $token = new TokenResponse(\json_decode(
            '{"code":0, "text":"", "token":"token"}'
        ));
        $this->apiMock->method('doOperation')->willReturn(new OperationResponse(\json_decode(
            '{"timestamp":"", "status":"done", "uuid":"", "error":null}'
        )));

        $request = new OperationRequest('', '', '', new Receipt(), new Info('', '', ''), $token);
        /**
         * @var OperationResponse $operation
         */
        $operation = $this->apiMock->doOperation($request);

        $this->assertEquals('done', $operation->getStatus());
    }
}
