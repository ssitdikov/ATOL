<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\ATOL\Response;


class GetTokenResponse implements ResponseInterface
{

    private $token = '';
    private $text = '';
    private $code = 0;

    public function __construct(\stdClass $json)
    {
        $this->token = $json->token;
        $this->text = $json->text;
        $this->code = $json->code;
    }

    public function jsonSerialize()
    {
        return [
            'token' => $this->token,
            'text' => $this->text,
            'code' => $this->code,
        ];
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