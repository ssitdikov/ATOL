<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorUndefinedException extends \Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            'Неизвестная ошибка, обратитесь в службу поддержки' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_UNDEFINED,
            $previous
        );
    }
}
