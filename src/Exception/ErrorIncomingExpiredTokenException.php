<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingExpiredTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Срок действия, переданнного <tokenid> истек (срок действия 24 часа). ' .
            'Необходимо запросить новый <tokenid>' . ($message ? ' ' . $message : ''),
            $code,
            $previous
        );
    }
}
