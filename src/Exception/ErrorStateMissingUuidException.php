<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorStateMissingUuidException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Передан некорректный UUID. Необходимо повторить запрос с корректными данными.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_STATE_MISSING_UUID,
            $previous
        );
    }
}
