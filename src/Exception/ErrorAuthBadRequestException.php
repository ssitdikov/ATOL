<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthBadRequestException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            'Некорректный запрос. Некорректная ссылка на авторизацию. '.
            'Необходимо повторить запрос с корректными данными.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::AUTH_BAD_REQUEST,
            $previous
        );
    }
}
