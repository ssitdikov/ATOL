<?php

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Code\ErrorCode;
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

    public function getMethod()
    {
        return self::GET;
    }

    public function getParams()
    {
        return [];
    }

    public function getUrl()
    {
        return $this->groupId . '/report/' . $this->uuid . '?tokenid=' . $this->token;
    }

    /**
     * @param $response
     * @return ReportResponse
     * @throws ErrorIncomingQueueException
     * @throws ErrorIncomingQueueTimeoutException
     * @throws ErrorIncomingValidationException
     * @throws ErrorStateBadRequestException
     * @throws ErrorStateExpiredTokenException
     * @throws ErrorStateMissingTokenException
     * @throws ErrorStateMissingUuidException
     * @throws ErrorStateNotExistTokenException
     * @throws ErrorStateNotFoundException
     * @throws \Exception
     */
    public function getResponse($response)
    {
        if (null !== $response->error || isset($response->code)) {
            switch ($response->code) {
                case (ErrorCode::ERROR_INCOMING_QUEUE_TIMEOUT):
                    throw new ErrorIncomingQueueTimeoutException('', ErrorCode::ERROR_INCOMING_QUEUE_TIMEOUT);
                    break;
                case (ErrorCode::ERROR_INCOMING_VALIDATION_EXCEPTION):
                    throw new ErrorIncomingValidationException('', ErrorCode::ERROR_INCOMING_VALIDATION_EXCEPTION);
                    break;
                case (ErrorCode::ERROR_INCOMING_QUEUE_EXCEPTION):
                    throw new ErrorIncomingQueueException('', ErrorCode::ERROR_INCOMING_QUEUE_EXCEPTION);
                    break;
                case (ErrorCode::ERROR_STATE_BAD_REQUEST):
                    throw new ErrorStateBadRequestException('', ErrorCode::ERROR_STATE_BAD_REQUEST);
                    break;
                case (ErrorCode::ERROR_STATE_MISSING_TOKEN):
                    throw new ErrorStateMissingTokenException('', ErrorCode::ERROR_STATE_MISSING_TOKEN);
                    break;
                case (ErrorCode::ERROR_STATE_NOT_EXIST_TOKEN):
                    throw new ErrorStateNotExistTokenException('', ErrorCode::ERROR_STATE_NOT_EXIST_TOKEN);
                    break;
                case (ErrorCode::ERROR_STATE_EXPIRED_TOKEN):
                    throw new ErrorStateExpiredTokenException('', ErrorCode::ERROR_STATE_EXPIRED_TOKEN);
                    break;
                case (ErrorCode::ERROR_STATE_MISSING_UUID):
                    throw new ErrorStateMissingUuidException('', ErrorCode::ERROR_STATE_MISSING_UUID);
                    break;
                case (ErrorCode::ERROR_STATE_NOT_FOUND):
                    throw new ErrorStateNotFoundException('', ErrorCode::ERROR_STATE_NOT_FOUND);
                    break;
                default:
                    throw new \Exception($response->text, $response->code);
            }
        }
        return new ReportResponse($response);
    }
}
