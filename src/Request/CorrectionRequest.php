<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Exception\ErrorException;
use SSitdikov\ATOL\Exception\ErrorGroupCodeToTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException;
use SSitdikov\ATOL\Exception\ErrorIncomingExistExternalIdException;
use SSitdikov\ATOL\Exception\ErrorIncomingExpiredTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingMissingTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingNotExistTokenException;
use SSitdikov\ATOL\Exception\ErrorIncomingOperationNotSupportException;
use SSitdikov\ATOL\Exception\ErrorIsNullExternalIdException;
use SSitdikov\ATOL\Object\Correction;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class CorrectionRequest
 * @package SSitdikov\ATOL\Request
 * @deprecated
 */
class CorrectionRequest implements RequestInterface
{

    const OPERATION_SELL_CORRECTION = 'sell_correction';
    const OPERATION_BUY_CORRECTION = 'buy_correction';

    private $groupId;
    private $uuid;
    private $info;
    private $correction;
    private $token;
    private $operation;

    public function __construct(
        $groupId,
        $operation,
        $uuid,
        Correction $correction,
        Info $info,
        TokenResponse $token
    ) {
        $this->groupId = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->correction = $correction;
        $this->info = $info;
        $this->token = $token->getToken();
    }

    public function getMethod(): string
    {
        return self::POST;
    }

    public function getParams(): array
    {
        return [
            'json' => [
                'timestamp' => date('d.m.Y H:i:s'),
                'external_id' => $this->uuid,
                'service' => $this->info,
                'correction' => $this->correction,
            ],
        ];
    }

    public function getUrl(): string
    {
        return $this->groupId.'/'.$this->operation.'?tokenid='.$this->token;
    }

    /**
     * @param $response
     * @return \SSitdikov\ATOL\Response\OperationResponse
     * @throws \Exception
     * @throws \SSitdikov\ATOL\Exception\ErrorException
     * @throws \SSitdikov\ATOL\Exception\ErrorGroupCodeToTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExistExternalIdException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExpiredTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingMissingTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingNotExistTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingOperationNotSupportException
     * @throws \SSitdikov\ATOL\Exception\ErrorIsNullExternalIdException
     */
    public function getResponse($response): OperationResponse
    {
        if (null !== $response->error) {
            switch ($response->error->code) {
                case (ErrorCode::ERROR):
                    throw new ErrorException(
                        'Ошибка при парсинге JSON. Повторите с новым уникальным значением '.
                        '<external_id>, указав корректные данные. '.$response->error->text,
                        ErrorCode::ERROR
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_BAD_REQUEST):
                    throw new ErrorIncomingBadRequestException(
                        'Переданые пустые значения <group_code> и/или '.
                        '<operation>. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_BAD_REQUEST
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT):
                    throw new ErrorIncomingOperationNotSupportException(
                        'Передано некорректное значение <operation>. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_MISSING_TOKEN):
                    throw new ErrorIncomingMissingTokenException(
                        'Передан некорректный <tokenid>. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_MISSING_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN):
                    throw new ErrorIncomingNotExistTokenException(
                        'Переданный <tokenid> не выдавался. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN):
                    throw new ErrorIncomingExpiredTokenException(
                        'Срок действия, переданного <tokenid> истек '.
                        '(срок действия 24 часа). Необходимо запросить новый. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID):
                    throw new ErrorIncomingExistExternalIdException(
                        'Документ с переданными значениями <external_id> и '.
                        '<group_code> уже существует. '.$response->error->text,
                        ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID
                    );
                    break;
                case (ErrorCode::ERROR_GROUP_CODE_TO_TOKEN):
                    throw new ErrorGroupCodeToTokenException(
                        'Передан некорректный <tokenid> или <group_code>. '.$response->error->text,
                        ErrorCode::ERROR_GROUP_CODE_TO_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_IS_NULL_EXTERNAL_ID):
                    throw new ErrorIsNullExternalIdException(
                        'Не был указан <external_id>.',
                        ErrorCode::ERROR_IS_NULL_EXTERNAL_ID
                    );
                    break;
                default:
                    throw new \Exception(
                        $response->error->text,
                        $response->error->code
                    );
                    break;
            }
        }

        return new OperationResponse($response);
    }
}
