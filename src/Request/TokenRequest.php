<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Code\SuccessCode;
use SSitdikov\ATOL\Exception\ErrorAuthBadRequestException;
use SSitdikov\ATOL\Exception\ErrorAuthGenTokenException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
use SSitdikov\ATOL\Exception\ErrorFactoryResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class TokenRequest implements RequestInterface
{

    private $login;
    private $pass;

    /**
     * GetTokenRequest constructor.
     * @param $login
     * @param $pass
     */
    public function __construct($login, $pass)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::POST;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'json' => [
                'login' => $this->login,
                'pass' => $this->pass,
            ],
        ];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return 'getToken/';
    }

    /**
     * @param $response
     * @return TokenResponse
     * @throws \Exception
     */
    public function getResponse($response)
    {
        if (in_array(
            $response->code,
            [SuccessCode::GET_TOKEN_CODE, SuccessCode::ISSUED_OLD_TOKEN_CODE],
            false
        )) {
            return new TokenResponse($response);
        }
        return ErrorFactoryResponse::getError($response->text, $response->code);
    }
}
