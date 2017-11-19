<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthGenTokenException extends \Exception
{
    public function __construct(
        string $message = 'Не удалось сформировать токен. '.
        'Необходимо повторить запрос.',
        int $code = ErrorCode::AUTH_GEN_TOKEN,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
