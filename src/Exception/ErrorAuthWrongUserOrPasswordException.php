<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthWrongUserOrPasswordException extends \Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct(
            'Неверный логин или пароль. '.
            'Необходимо повторить запрос с корректными данными.' .
            ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }

}
