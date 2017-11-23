<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorStateBadRequestException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Не указан <group_code>. Необходимо повторить запрос на получение результата обработки документа ' .
            'с корректными данными.' . ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_STATE_BAD_REQUEST,
            $previous
        );
    }
}
