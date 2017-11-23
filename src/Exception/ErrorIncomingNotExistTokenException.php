<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingNotExistTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Переданный <tokenid> не выдавался. Необходимо повторить запрос с новым уникальным значением ' .
            '<external_id>, указав корректные данные.' . ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN,
            $previous
        );
    }
}
