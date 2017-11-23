<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingQueueException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Проблемы со связью очереди чеков. Обратитесь к администратору.' .
            ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }
}
