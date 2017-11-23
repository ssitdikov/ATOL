<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorStateMissingTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Передан некорректный <tokenid>. Необходимо повторить запрос на получение результата обработки ' .
            'с корректными данными. Если с момента получения <tokenid> прошло больше 24 часов, заново ' .
            'запросить <tokenid>.' . ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_STATE_MISSING_TOKEN,
            $previous
        );
    }
}
