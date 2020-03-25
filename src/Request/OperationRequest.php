<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use Exception;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class OperationRequest
 *
 * @package SSitdikov\ATOL\Request
 */
class OperationRequest implements RequestInterface
{

    public const OPERATION_SELL = 'sell';
    public const OPERATION_SELL_REFUND = 'sell_refund';
    public const OPERATION_SELL_CORRECTION = 'sell_correction';
    public const OPERATION_BUY = 'buy';
    public const OPERATION_BUY_REFUND = 'buy_refund';
    public const OPERATION_BUY_CORRECTION = 'buy_correction';

    private $groupId;
    private $uuid;
    private $receipt;
    private $info;
    private $token;
    private $operation;

    /**
     * OperationRequest constructor.
     *
     * @param               $groupId
     * @param               $operation
     * @param               $uuid
     * @param Receipt       $receipt
     * @param Info          $info
     * @param TokenResponse $token
     */
    public function __construct(
        $groupId,
        $operation,
        $uuid,
        Receipt $receipt,
        Info $info,
        TokenResponse $token
    )
    {
        $this->groupId = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->receipt = $receipt;
        $this->info = $info;
        $this->token = $token->getToken();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'json' => [
                'external_id' => $this->uuid,
                'receipt'     => $this->receipt,
                'service'     => $this->info,
                'timestamp'   => date('d.m.Y H:i:s'),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->groupId . '/' . $this->operation . '?token=' . $this->token;
    }

    /**
     * @param $response
     * @return OperationResponse
     *
     * @throws Exception
     */
    public function getResponse($response): ResponseInterface
    {
        if (isset($response->error)) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }

        return new OperationResponse($response);
    }
}
