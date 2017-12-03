<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingBadRequestException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Переданы пустые значения <group_code> и/или <operation>. ' .
            'Необходмио повторить запрос с новым уникальным значением <external_id>, указав корректные данные.' .
            ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }
}
