<?php

namespace SSitdikov\ATOL\Response;

class ReportResponse implements ResponseInterface
{

    const STATUS_DONE = 'done';
    const STATUS_FAIL = 'fail';
    const STATUS_WAIT = 'wait';

    /**
     * @var string
     */
    private $uuid;
    private $error;
    /**
     * @var string
     */
    private $status = self::STATUS_WAIT;
    private $payload;
    /**
     * @var string
     */
    private $timestamp;
    /**
     * @var string
     */
    private $group_code;
    /**
     * @var string
     */
    private $daemon_code;
    /**
     * @var string
     */
    private $device_code;
    /**
     * @var string
     */
    private $callback_url;

    public function __construct(\stdClass $json)
    {
        $this->uuid = $json->uuid;
        $this->error = $json->error ? new ErrorResponse($json->error) : null;
        $this->payload = $json->payload ? new PayloadResponse($json->payload) : null;
        $this->status = $json->status;
        $this->timestamp = $json->timestamp;
        $this->group_code = $json->group_code;
        $this->daemon_code = $json->daemon_code;
        $this->device_code = $json->device_code;
        $this->callback_url = $json->callback_url;
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
    public function getError()
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
        return $this->group_code;
    }

    /**
     * @return string
     */
    public function getDaemonCode(): string
    {
        return $this->daemon_code;
    }

    /**
     * @return string
     */
    public function getDeviceCode(): string
    {
        return $this->device_code;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callback_url;
    }
}
