<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Response\GetTokenResponse;

class GetTokenRequest implements RequestInterface
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

    public function getMethod()
    {
        return self::POST;
    }

    public function getParams()
    {
        return [
            'json' => [
                'login' => $this->login,
                'pass' => $this->pass,
            ]
        ];
    }

    public function getUrl()
    {
        return 'getToken/';
    }

    public function getResponse($response)
    {
        return new GetTokenResponse(json_decode($response));
    }

}