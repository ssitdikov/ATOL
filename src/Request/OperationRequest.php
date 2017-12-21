<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Exception\ErrorException;
use SSitdikov\ATOL\Exception\ErrorFactoryResponse;
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

    const UUID_TEXT_ID = "UUID=";

    private $groupId;
    private $uuid;
    private $receipt;
    private $info;
    private $token;
    private $operation;

    public function __construct(
        $groupId,
        $operation,
        $uuid,
        Receipt $receipt,
        Info $info,
        TokenResponse $token
    ) {
        $this->groupId = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->receipt = $receipt;
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
                'external_id' => $this->uuid,
                'receipt' => $this->receipt,
                'service' => $this->info,
                'timestamp' => date('d.m.Y H:i:s'),
            ],
        ];
    }

    public function getUrl(): string
    {
        return $this->groupId.'/'.$this->operation.'?tokenid='.$this->token;
    }

    /**
     * @param $response
     * @return OperationResponse
     */
    public function getResponse($response)
    {
        if (null !== $response->error) {
            ErrorFactoryResponse::getError($this->getErrorMessage($response), $response->error->code);
        }

        return new OperationResponse($response);
    }

    /**
     * @param $response
     * @return string
     */
    private function getErrorMessage($response)
    {
        if ($response->error->code !== ErrorCode::ERROR_INCOMING_EXIST_EXTERNAL_ID) {
            return $response->error->text;
        }

        if (!$response->uuid) {
            return $response->error->text;
        }

        return implode(' ', [
            $response->error->text,
            self::UUID_TEXT_ID.$response->uuid,
        ]);
    }
}
