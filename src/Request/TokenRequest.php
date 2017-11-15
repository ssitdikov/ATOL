<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Code\SuccessCode;
use SSitdikov\ATOL\Exception\ErrorAuthBadRequestException;
use SSitdikov\ATOL\Exception\ErrorAuthGenTokenException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
use SSitdikov\ATOL\Response\GetTokenResponse;

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
            case (SuccessCode::GET_TOKEN_CODE):
            case (SuccessCode::ISSUED_OLD_TOKEN_CODE):
                return new GetTokenResponse($response);
                break;
            case (ErrorCode::AUTH_BAD_REQUEST):
                throw new ErrorAuthBadRequestException('Некорректный запрос. Некорректная ссылка на авторизацию. ' .
                    'Необходимо повторить запрос с корректными данными.', ErrorCode::AUTH_BAD_REQUEST);
                break;
            case (ErrorCode::AUTH_GEN_TOKEN):
                throw new ErrorAuthGenTokenException('Не удалось сформировать токен. ' .
                    'Необходимо повторить запрос.', ErrorCode::AUTH_GEN_TOKEN);
                break;
            case (ErrorCode::AUTH_WORKING_USER_OR_PASSWORD):
                throw new ErrorAuthWrongUserOrPasswordException('Неверный логин или пароль. ' .
                    'Необходимо повторить запрос с корректными данными.', ErrorCode::AUTH_WORKING_USER_OR_PASSWORD);
                break;
            default:
                throw new \Exception($response->text, $response->code);
        }
    }
}
