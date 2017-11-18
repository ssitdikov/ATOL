<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.11.17
 * Time: 7:03
 */

namespace SSitdikov\ATOL\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use SSitdikov\ATOL\Client\ApiClient;
use PHPUnit\Framework\TestCase;
use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Exception\ErrorAuthBadRequestException;
use SSitdikov\ATOL\Object\Correction;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\TokenResponse;

class ApiClientTest extends TestCase
{
    /**
     * @test
     */
    public function getTokenRequest()
    {
        $client = $this->getMockBuilder(Client::class)->getMock();

        $token = md5(time());
        $response = new Response(200, [], '{"code":0, "text":"", "token":"' . $token . '"}');
        $client->expects($this->once())
            ->method('request')->willReturn($response);

        $api = new ApiClient($client);

        $request = new TokenRequest('login', 'password');
        $tokenResponse = $api->getToken($request);

        $this->assertEquals($token, $tokenResponse->getToken());
    }
    
    /**
     * @test
     */
    public function doOperation()
    {
        $client = $this->getMockBuilder(Client::class)->getMock();

        $uuid = md5(time());
        $response = new Response(
            200,
            [],
            '{"uuid":"'.$uuid.'", "error":null, "status":"", "timestamp":""}'
        );
        $client->expects($this->once())
            ->method('request')->willReturn($response);

        $api = new ApiClient($client);

        $request = new OperationRequest(
            '',
            '',
            '',
            new Receipt(),
            new Info('', '', ''),
            new TokenResponse(\json_decode('{"code":0, "text":"", "token":"token"}'))
        );
        $operationResponse = $api->doOperation($request);

        $this->assertEquals($uuid, $operationResponse->getUuid());
    }

    /**
     *
     */
    public function doCorrection()
    {
        $client = $this->getMockBuilder(Client::class)->getMock();

        $uuid = md5(time());
        $response = new Response(
            200,
            [],
            '{"uuid":"'.$uuid.'", "error":null, "status":"", "timestamp":""}'
        );
        $client->expects($this->once())
            ->method('request')->willReturn($response);

        $api = new ApiClient($client);

        $request = new CorrectionRequest(
            '',
            '',
            '',
            new Correction(),
            new Info('', '', ''),
            new TokenResponse(\json_decode('{"code":0, "text":"", "token":"token"}'))
        );
        $operationResponse = $api->doCorrection($request);

        $this->assertEquals($uuid, $operationResponse->getUuid());
    }

    /**
     * @test
     */
    public function getReport()
    {
        $client = $this->getMockBuilder(Client::class)->getMock();

        $uuid = md5(time());
        $response = new Response(
            200,
            [],
            '{"uuid":"'.$uuid.'", "error":null, "status":"", "payload":null, "timestamp":"", "group_code":"",' .
            '"daemon_code":"", "device_code":"", "callback_url":""}'
        );
        $client->expects($this->once())
            ->method('request')->willReturn($response);

        $api = new ApiClient($client);

        $request = new ReportRequest(
            '',
            '',
            new TokenResponse(\json_decode('{"code":0, "text":"", "token":"token"}'))
        );

        $report = $api->getReport($request);

        $this->assertEquals($uuid, $report->getUuid());
    }
}
