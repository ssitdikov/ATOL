<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorStateNotExistTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Переданный <tokenid> не выдавался. Необходимо повторить запрос с корректными данными. ' .
            'Если с момент получения <tokenid> прошло больше 24 часов, необходимо заново запросить <tokenid>.' .
            ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }
}
