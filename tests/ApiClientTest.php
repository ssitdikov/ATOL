<?php

namespace SSitdikov\ATOL\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use SSitdikov\ATOL\ApiClient;
use SSitdikov\ATOL\Request\GetTokenRequest;

class ApiClientTest extends TestCase
{

    /**
     * @test
     * @dataProvider tokenGeneratedProvider
     */
    public function testGetToken($json, $code, $token, $text)
    {
        $http = $this->createMock(Client::class);
        $response = $this->createMock(Response::class);
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')->willReturn($json);
        $response->method('getBody')->willReturn($stream);
        $http->method('request')
            ->willReturn($response);

        $atol = new ApiClient($http);

        $tokenRequest = new GetTokenRequest('login', 'pass');
        $getToken = $atol->makeRequest($tokenRequest);

        $this->assertEquals($code, $getToken->getCode());
        $this->assertEquals($token, $getToken->getToken());
        $this->assertEquals($text, $getToken->getText());

    }

    public function tokenGeneratedProvider(){
        $tokens = [];
        for ($i = 0; $i < 10; $i++){
            $token = new \stdClass();
            $token->code = $i;
            $token->token = substr(md5(time()), 0, 32);
            $token->text = md5(time() . $i . sha1(random_int(1000,9999)));
            $tokens[] = [
                json_encode($token),
                $token->code,
                $token->token,
                $token->text,
            ];
        }
        return $tokens;
    }

}
