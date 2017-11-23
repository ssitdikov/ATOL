<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingOperationNotSupportException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Передано некорректное значение <operation>. Необходимо повторить запрос с новым уникальным ' .
            'значением <external_id>, указав корректные данные.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT,
            $previous
        );
    }
}
