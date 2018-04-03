<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\SuccessCode;
use SSitdikov\ATOL\Exception\ErrorFactoryResponse;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class TokenRequest
 * @package SSitdikov\ATOL\Request
 */
class TokenRequest implements RequestInterface
{
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
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
                'pass' => $this->pass
            ]
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
    public function getResponse($response): TokenResponse
    {
        if (\in_array(
            $response->code,
            [SuccessCode::GET_TOKEN_CODE, SuccessCode::ISSUED_OLD_TOKEN_CODE],
            false
        )) {
            return new TokenResponse($response);
        }
        return ErrorFactoryResponse::getError($response->text, $response->code);
    }
}
