<?php

namespace SSitdikov\ATOL\Exception;

use SSitdikov\ATOL\Code\ErrorCode;

class ErrorFactoryResponse
{

    const ERROR_MAP = [
        ErrorCode::ERROR => ErrorException::class,
        ErrorCode::ERROR_INCOMING_BAD_REQUEST => ErrorIncomingBadRequestException::class,
        ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT => ErrorIncomingOperationNotSupportException::class,
        ErrorCode::ERROR_INCOMING_MISSING_TOKEN => ErrorIncomingMissingTokenException::class,
        ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN => ErrorIncomingNotExistTokenException::class,
        ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN => ErrorIncomingExpiredTokenException::class,
        ErrorCode::ERROR_INCOMING_QUEUE_TIMEOUT => ErrorIncomingQueueTimeoutException::class,
        ErrorCode::ERROR_INCOMING_VALIDATION_EXCEPTION => ErrorIncomingValidationException::class,
        ErrorCode::ERROR_INCOMING_QUEUE_EXCEPTION => ErrorIncomingQueueException::class,
        ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID => ErrorIncomingExistExternalIdException::class,
        ErrorCode::ERROR_STATE_BAD_REQUEST => ErrorStateBadRequestException::class,
        ErrorCode::ERROR_STATE_MISSING_TOKEN => ErrorStateMissingTokenException::class,
        ErrorCode::ERROR_STATE_NOT_EXIST_TOKEN => ErrorStateNotExistTokenException::class,
        ErrorCode::ERROR_STATE_EXPIRED_TOKEN => ErrorStateExpiredTokenException::class,
        ErrorCode::ERROR_STATE_MISSING_UUID => ErrorStateMissingUuidException::class,
        ErrorCode::ERROR_STATE_NOT_FOUND => ErrorStateNotFoundException::class,
        ErrorCode::AUTH_BAD_REQUEST => ErrorAuthBadRequestException::class,
        ErrorCode::AUTH_GEN_TOKEN => ErrorAuthGenTokenException::class,
        ErrorCode::AUTH_WRONG_USER_OR_PASSWORD => ErrorAuthWrongUserOrPasswordException::class,
        ErrorCode::ERROR_GROUP_CODE_TO_TOKEN => ErrorGroupCodeToTokenException::class,
        ErrorCode::ERROR_IS_NULL_EXTERNAL_ID => ErrorIsNullExternalIdException::class,
        ErrorCode::ERROR_UNDEFINED => ErrorUndefinedException::class,
    ];

    /**
     * @param $message
     * @param int $errorCode
     */
    public static function getError($message = '', $errorCode = 0)
    {
        $exception = self::ERROR_MAP[ $errorCode ] ?? \Exception::class;
        throw new $exception($message, $errorCode);
    }
}
