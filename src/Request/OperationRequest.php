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
 * Class OperationRequest.
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
    ) {
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
                'timestamp'   => date('d.m.Y H:i:s'),
                'external_id' => $this->uuid,
                'service'     => $this->info,
                'receipt'     => $this->receipt,
            ],
            'headers' => [
                'Token' => $this->token,
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
     *
     * @throws Exception
     * @return OperationResponse
     *
     */
    public function getResponse($response): ResponseInterface
    {
        // при попытке повторной регистрации чека, АТОЛ возвращает код ошибки 33 и UUID чека,
        // который можно вернуть как нормальный ответ, вместо исключения
        if (isset($response->error) && (int)$response->error->code !== 33) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }

        return new OperationResponse($response);
    }
}
