<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Exception\ErrorAuthBadRequestException;
use SSitdikov\ATOL\Exception\ErrorAuthGenTokenException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
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

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::POST;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'json' => [
                'login' => $this->login,
                'pass' => $this->pass,
            ]
        ];
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'getToken/';
    }

    /**
     * @param $response
     * @return GetTokenResponse
     * @throws ErrorAuthBadRequestException
     * @throws ErrorAuthGenTokenException
     * @throws ErrorAuthWrongUserOrPasswordException
     * @throws \Exception
     */
    public function getResponse($response)
    {
        switch ($response->code) {
            case 0:
            case 1:
                return new GetTokenResponse($response);
                break;
            case 17:
                throw new ErrorAuthBadRequestException('Некорректный запрос. Некорректная ссылка на авторизацию. ' .
                    'Необходимо повторить запрос с корректными данными.', $response->code);
                break;
            case 18:
                throw new ErrorAuthGenTokenException('Не удалось сформировать токен. ' .
                    'Необходимо повторить запрос.', $response->code);
                break;
            case 19:
                throw new ErrorAuthWrongUserOrPasswordException('Неверный логин или пароль. ' .
                    'Необходимо повторить запрос с корректными данными.', $response->code);
                break;
            default:
                throw new \Exception($response->text, $response->code);
        }
    }
}
