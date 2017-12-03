<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
use SSitdikov\ATOL\Exception\ErrorFactoryResponse;
use SSitdikov\ATOL\Exception\ErrorIncomingQueueException;
use SSitdikov\ATOL\Exception\ErrorIncomingQueueTimeoutException;
use SSitdikov\ATOL\Exception\ErrorIncomingValidationException;
use SSitdikov\ATOL\Exception\ErrorStateBadRequestException;
use SSitdikov\ATOL\Exception\ErrorStateExpiredTokenException;
use SSitdikov\ATOL\Exception\ErrorStateMissingTokenException;
use SSitdikov\ATOL\Exception\ErrorStateMissingUuidException;
use SSitdikov\ATOL\Exception\ErrorStateNotExistTokenException;
use SSitdikov\ATOL\Exception\ErrorStateNotFoundException;
use SSitdikov\ATOL\Response\ReportResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class ReportRequest implements RequestInterface
{
    /**
     * @var string
     */
    private $groupId;
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var string
     */
    private $token;

    public function __construct($groupId, $uuid, TokenResponse $token)
    {
        $this->groupId = $groupId;
        $this->uuid = $uuid;
        $this->token = $token->getToken();
    }

    public function getMethod(): string
    {
        return self::GET;
    }

    public function getParams(): array
    {
        return [];
    }

    public function getUrl(): string
    {
        return $this->groupId.'/report/'.$this->uuid.'?tokenid='.$this->token;
    }

    /**
     * @param $response
     * @return ReportResponse
     */
    public function getResponse($response)
    {
        if (null !== $response->error) {
            ErrorFactoryResponse::getError($response->error->text, $response->error->code);
        }

        return new ReportResponse($response);
    }
}
