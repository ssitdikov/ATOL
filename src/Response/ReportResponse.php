<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

use stdClass;

/**
 * Class ReportResponse.
 *
 * @package SSitdikov\ATOL\Response
 */
class ReportResponse implements ResponseInterface
{

    public const STATUS_DONE = 'done';
    public const STATUS_FAIL = 'fail';
    public const STATUS_WAIT = 'wait';

    /**
     * @var string
     */
    private $uuid;

    private $error;

    /**
     * @var string
     */
    private $status;

    private $payload;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var string
     */
    private $groupCode;

    /**
     * @var string
     */
    private $daemonCode;

    /**
     * @var string
     */
    private $deviceCode;

    /**
     * @var string
     */
    private $callbackUrl;


    /**
     * ReportResponse constructor.
     *
     * @param stdClass $json
     */
    public function __construct(stdClass $json)
    {
        $this->uuid = $json->uuid;
        $this->error = $json->error ? new ErrorResponse($json->error) : null;
        $this->payload = $json->payload ? new PayloadResponse($json->payload) : null;
        $this->status = $json->status;
        $this->timestamp = $json->timestamp;
        $this->groupCode = $json->group_code;
        $this->daemonCode = $json->daemon_code;
        $this->deviceCode = $json->device_code;
        $this->callbackUrl = $json->callback_url;
    }


    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }


    /**
     * @return null|ErrorResponse
     */
    public function getError(): ?ErrorResponse
    {
        return $this->error;
    }


    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * @return null|PayloadResponse
     */
    public function getPayload(): PayloadResponse
    {
        return $this->payload;
    }


    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }


    /**
     * @return string
     */
    public function getGroupCode(): string
    {
        return $this->groupCode;
    }


    /**
     * @return string
     */
    public function getDaemonCode(): string
    {
        return $this->daemonCode;
    }


    /**
     * @return string
     */
    public function getDeviceCode(): string
    {
        return $this->deviceCode;
    }


    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }
}
