<?php

namespace SSitdikov\ATOL\Request;

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

    public function getResponse($response)
    {
        return $response;
    }
}
