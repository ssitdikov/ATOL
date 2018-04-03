<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

/**
 * Class TokenResponse
 * @package SSitdikov\ATOL\Response
 */
class TokenResponse implements ResponseInterface
{

    private $token;
    private $text;
    private $code;

    /**
     * TokenResponse constructor.
     * @param \stdClass $json
     */
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
