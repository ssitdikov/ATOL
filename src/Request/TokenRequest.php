<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use Exception;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class TokenRequest.
 *
 * @package SSitdikov\ATOL\Request
 *
 * @author  Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenRequest implements RequestInterface
{
    /**
     * @var string $login
     */
    private $login;

    /**
     * @var string $password
     */
    private $password;


    /**
     * TokenRequest constructor.
     *
     * @param string $login
     * @param string $password
     */
    public function __construct(
        string $login,
        string $password
    ) {
        $this->login = $login;
        $this->password = $password;
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }


    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'json' => [
                'login' => $this->login,
                'pass'  => $this->password,
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
     *
     * @throws Exception
     * @return TokenResponse
     *
     */
    public function getResponse($response): ResponseInterface
    {
        if (isset($response->error)) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }
        return new TokenResponse($response);
    }
}
