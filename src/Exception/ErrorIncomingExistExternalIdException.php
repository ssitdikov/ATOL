<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorIncomingExistExternalIdException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Документ с переданными значениями <external_id> и <group_code> уже существует в базе. ' .
            'В ответе на ошибку будет передан UUID первого присланного чека с данными параметрами. ' .
            'Можно воспользоваться запросом на получение резльутата регистрации, указав UUID.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID,
            $previous
        );
    }
}
