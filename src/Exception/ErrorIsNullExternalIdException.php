<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIsNullExternalIdException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Не был указан <external_id>. Системой для данного чека был выдан <external_id> и отправлен ' .
            'на регистрацию. В дальнейшем вам необходимо самостоятельно указывать уникальный <external_id> ' .
            'для каждого чека.' . ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_IS_NULL_EXTERNAL_ID,
            $previous
        );
    }
}
