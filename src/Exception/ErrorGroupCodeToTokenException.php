<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorGroupCodeToTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Передан некорректный <tokenid> или <group_code>. Необходимо повторить запрос с новым ' .
            'уникальным знаением <external_id>, указав корректные данные.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_GROUP_CODE_TO_TOKEN,
            $previous
        );
    }
}
