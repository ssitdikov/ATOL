<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;
use Throwable;

class ErrorStateNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Документ еще не обработан. Необходимо повторить запрос на получение резльутата обработки ' .
            'чека позднее. Повторно отправлять чек на регистрацию не нужно.' .
            ($message ? ' ' . $message : ''),
            ErrorCode::ERROR_STATE_NOT_FOUND,
            $previous
        );
    }
}
