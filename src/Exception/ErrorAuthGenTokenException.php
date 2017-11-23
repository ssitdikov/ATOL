<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthGenTokenException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            'Не удалось сформировать токен. '.
            'Необходимо повторить запрос.' . ($message ? ' ' . $message : ''),
            ErrorCode::AUTH_GEN_TOKEN,
            $previous
        );
    }
}
