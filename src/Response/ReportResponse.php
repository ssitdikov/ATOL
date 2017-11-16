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
}
