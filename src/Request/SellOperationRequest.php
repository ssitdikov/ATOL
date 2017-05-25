<?php
/**
 * Created by PhpStorm.
 * User: sitdikov
 * Date: 25.05.17
 * Time: 15:48
 */

namespace SSitdikov\ATOL\Request;


use SSitdikov\ATOL\Object\Info;
use SSitdikov\ATOL\Object\Receipt;
use SSitdikov\ATOL\Response\GetTokenResponse;
use SSitdikov\ATOL\Response\SellOperationResponse;

class SellOperationRequest implements RequestInterface
{

    private $group_id = '';
    private $uuid = '';
    private $receipt;
    private $info;
    private $token = '';

    public function __construct($groupId = '', $uuid = '', Receipt $receipt, Info $info, GetTokenResponse $tokenResponse)
    {
        $this->group_id = $groupId;
        $this->uuid = $uuid;
        $this->receipt = $receipt;
        $this->info = $info;
        $this->token = $tokenResponse->getToken();
    }


    public function getMethod()
    {
        return self::POST;
    }

    public function getParams()
    {
        return [
            'json' => [
            'timestamp' => date('d.m.Y H:i:s'),
            'external_id' => $this->uuid,
            'receipt' => $this->receipt,
            'service' => $this->info,
                ],
        ];
    }

    public function getUrl()
    {
        return $this->group_id . '/sell?tokenid=' . $this->token;
    }

    public function getResponse($response)
    {
        return new SellOperationResponse(json_decode($response));
    }


}