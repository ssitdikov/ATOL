<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use Exception;
use SSitdikov\ATOL\Object\Correction;
use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Class CorrectionRequest.
 *
 * @package SSitdikov\ATOL\Request
 */
class CorrectionRequest implements RequestInterface
{

    private $groupId;

    private $uuid;

    private $info;

    private $correction;

    private $token;

    private $operation;


    /**
     * CorrectionRequest constructor.
     *
     * @param               $groupId
     * @param               $operation
     * @param               $uuid
     * @param Correction    $correction
     * @param Info          $info
     * @param TokenResponse $token
     */
    public function __construct(
        $groupId,
        $operation,
        $uuid,
        Correction $correction,
        Info $info,
        TokenResponse $token
    )
    {
        $this->groupId = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->correction = $correction;
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
            'json'    => [
                'timestamp'   => date('d.m.Y H:i:s'),
                'external_id' => $this->uuid,
                'service'     => $this->info,
                'correction'  => $this->correction,
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
        return $this->groupId . '/' . $this->operation . '?tokenid=' . $this->token;
    }


    /**
     * @param $response
     *
     * @throws Exception
     * @return OperationResponse
     */
    public function getResponse($response): ResponseInterface
    {
        if (isset($response->error) && (int)$response->error->code !== 33) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }
        return new OperationResponse($response);
    }
}
