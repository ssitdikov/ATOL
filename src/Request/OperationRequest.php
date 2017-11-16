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
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class OperationRequest implements RequestInterface
{

    const OPERATION_SELL = 'sell';
    const OPERATION_SELL_REFUND = 'sell_refund';
    const OPERATION_BUY = 'buy';
    const OPERATION_BUY_REFUND = 'buy_refund';

    private $group_id = '';
    private $uuid = '';
    private $receipt;
    private $info;
    private $token = '';
    private $operation = self::OPERATION_SELL;

    public function __construct($groupId, $operation, $uuid, Receipt $receipt, Info $info, TokenResponse $token)
    {
        $this->group_id = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->receipt = $receipt;
        $this->info = $info;
        $this->token = $token->getToken();
    }


    public function getMethod()
    {
        return self::POST;
    }

    public function getParams()
    {
        return [
            'json' => [
                'external_id' => $this->uuid,
                'receipt' => $this->receipt,
                'service' => $this->info,
                'timestamp' => date('d.m.Y H:i:s'),
            ],
        ];
    }

    public function getUrl()
    {
        return $this->group_id . '/' . $this->operation . '?tokenid=' . $this->token;
    }

    /**
     * @param $response
     * @return OperationResponse
     * @throws ErrorException
     * @throws ErrorGroupCodeToTokenException
     * @throws ErrorIncomingBadRequestException
     * @throws ErrorIncomingExistExternalIdException
     * @throws ErrorIncomingExpiredTokenException
     * @throws ErrorIncomingMissingTokenException
     * @throws ErrorIncomingNotExistTokenException
     * @throws ErrorIncomingOperationNotSupportException
     * @throws ErrorIsNullExternalIdException
     * @throws \Exception
     */
    public function getResponse($response)
    {
        if (null !== $response->error || isset($response->code)) {
            switch ($response->error->code) {
                case ErrorCode::ERROR:
                    throw new ErrorException('Ошибка при парсинге JSON. Повторите с новым уникальным значением ' .
                        '<external_id>, указав корректные данные. ' . $response->error->text, ErrorCode::ERROR);
                    break;
                case (ErrorCode::ERROR_INCOMING_BAD_REQUEST):
                    throw new ErrorIncomingBadRequestException('Переданые пустые значения <group_code> и/или ' .
                        '<operation>. ' . $response->error->text, ErrorCode::ERROR_INCOMING_BAD_REQUEST);
                    break;
                case (ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT):
                    throw new ErrorIncomingOperationNotSupportException(
                        'Передано некорректное значение <operation>. ' . $response->error->text,
                        ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_MISSING_TOKEN):
                    throw new ErrorIncomingMissingTokenException(
                        'Передан некорректный <tokenid>. ' . $response->error->text,
                        ErrorCode::ERROR_INCOMING_MISSING_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN):
                    throw new ErrorIncomingNotExistTokenException(
                        'Переданный <tokenid> не выдавался. ' . $response->error->text,
                        ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN):
                    throw new ErrorIncomingExpiredTokenException(
                        'Срок действия, переданного <tokenid> истек ' .
                        '(срок действия 24 часа). Необходимо запросить новый. ' . $response->error->text,
                        ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID):
                    throw new ErrorIncomingExistExternalIdException(
                        'Документ с переданными значениями <external_id> и ' .
                        '<group_code> уже существует. ' . $response->error->text,
                        ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID
                    );
                    break;
                case (ErrorCode::ERROR_GROUP_CODE_TO_TOKEN):
                    throw new ErrorGroupCodeToTokenException(
                        'Передан некорректный <tokenid> или <group_code>. ' . $response->error->text,
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
                    throw new \Exception($response->text, $response->code);
                    break;
            }
        }
        return new OperationResponse($response);
    }
}
