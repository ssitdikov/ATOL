<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorAuthBadRequestException extends \Exception
{
    public function __construct(
        string $message = 'Некорректный запрос. Некорректная ссылка на авторизацию. '.
        'Необходимо повторить запрос с корректными данными.',
        int $code = ErrorCode::AUTH_BAD_REQUEST,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }


}
