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
use SSitdikov\ATOL\Response\GetTokenResponse;
use SSitdikov\ATOL\Response\SellOperationResponse;

class SellOperationRequest implements RequestInterface
{

    private $group_id = '';
    private $uuid = '';
    private $receipt;
    private $info;
    private $token = '';

    public function __construct($groupId, $uuid, Receipt $receipt, Info $info, GetTokenResponse $token)
    {
        $this->group_id = $groupId;
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
        return $this->group_id . '/sell?tokenid=' . $this->token;
    }

    /**
     * @param $response
     * @return SellOperationResponse
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
                        '<external_id>, указав корректные данные', ErrorCode::ERROR);
                    break;
                case (ErrorCode::ERROR_INCOMING_BAD_REQUEST):
                    throw new ErrorIncomingBadRequestException('Переданые пустые значения <group_code> и/или ' .
                        '<operation>', ErrorCode::ERROR_INCOMING_BAD_REQUEST);
                    break;
                case (ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT):
                    throw new ErrorIncomingOperationNotSupportException(
                        'Передано некорректное значение <operation>',
                        ErrorCode::ERROR_INCOMING_OPERATION_NOT_SUPPORT
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_MISSING_TOKEN):
                    throw new ErrorIncomingMissingTokenException(
                        'Передан некорректный <tokenid>.',
                        ErrorCode::ERROR_INCOMING_MISSING_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN):
                    throw new ErrorIncomingNotExistTokenException(
                        'Переданный <tokenid> не выдавался.',
                        ErrorCode::ERROR_INCOMING_NOT_EXIST_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN):
                    throw new ErrorIncomingExpiredTokenException(
                        'Срок действия, переданного <tokenid> истек ' .
                        '(срок действия 24 часа). Необходимо запросить новый.',
                        ErrorCode::ERROR_INCOMING_EXPIRED_TOKEN
                    );
                    break;
                case (ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID):
                    throw new ErrorIncomingExistExternalIdException(
                        'Документ с переданными значениями <external_id> и ' .
                        '<group_code> уже существует.',
                        ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID
                    );
                    break;
                case (ErrorCode::ERROR_GROUP_CODE_TO_TOKEN):
                    throw new ErrorGroupCodeToTokenException(
                        'Передан некорректный <tokenid> или <group_code>',
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
        return new SellOperationResponse($response);
    }
}
