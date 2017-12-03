<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Exception\ErrorFactoryResponse;
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
     * @return OperationResponse
     */
    public function getResponse($response): OperationResponse
    {
        if (null !== $response->error) {
            ErrorFactoryResponse::getError($response->error->text, $response->error->code);
        }

        return new OperationResponse($response);
    }
}
