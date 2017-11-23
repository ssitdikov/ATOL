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
     */
    public function getResponse($response)
    {
        switch ($response->code) {
            case (SuccessCode::GET_TOKEN_CODE):
            case (SuccessCode::ISSUED_OLD_TOKEN_CODE):
                return new TokenResponse($response);
                break;
        }
        ErrorFactoryResponse::getError($response->text, $response->code);
        return null;
    }
}
