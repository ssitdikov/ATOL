<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingQueueTimeoutException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Не создан сервер очередей. Обратитесь к администратору.' .
            ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }
}
