<?php

namespace SSitdikov\ATOL\Response;

class TokenResponse implements ResponseInterface
{

    private $token;
    private $text;
    private $code;

    public function __construct(\stdClass $json)
    {
        $this->token = $json->token ?: '';
        $this->text = $json->text ?: '';
        $this->code = $json->code;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
