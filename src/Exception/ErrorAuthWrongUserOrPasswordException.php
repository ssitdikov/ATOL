<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthWrongUserOrPasswordException extends \Exception
{
    public function __construct(
        string $message = 'Неверный логин или пароль. '.
        'Необходимо повторить запрос с корректными данными.',
        int $code = ErrorCode::AUTH_WORKING_USER_OR_PASSWORD,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}
