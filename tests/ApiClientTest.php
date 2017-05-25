<?php

namespace SSitdikov\ATOL\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use SSitdikov\ATOL\ApiClient;
use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Code\SuccessCode;
use SSitdikov\ATOL\Request\GetTokenRequest;

class ApiClientTest extends TestCase
{

    /**
     * @test
     * @dataProvider tokenGeneratedProvider
     * @dataProvider tokenOriginalProvider
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

    public function tokenOriginalProvider(){
        $correctToken = [
            'code' => SuccessCode::GetTokenCode,
            'text' => '',
            'token' => md5(time()),
        ];
        $notValidToken = [
            'code' => ErrorCode::NotValidTokenCode,
            'text' => 'Not Valid Token Code',
            'token' => '',
        ];
        $oldToken = [
            'code' => SuccessCode::IssuedOldTokenCode,
            'text' => 'Issued Old Token Code',
            'token' => md5(time()),
        ];
        return [
            [json_encode($correctToken), $correctToken['code'], $correctToken['token'], $correctToken['text']],
            [json_encode($notValidToken), $notValidToken['code'], $notValidToken['token'], $notValidToken['text']],
            [json_encode($oldToken), $oldToken['code'], $oldToken['token'], $oldToken['text']],

        ];
    }

}
