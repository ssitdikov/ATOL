<?php

namespace SSitdikov\ATOL\Response;

class ErrorResponse implements ResponseInterface
{

    /**
     * @var int
     */
    private $code = 0;

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var string
     */
    private $type = '';

    public function __construct(\stdClass $json)
    {
        $this->code = $json->code;
        $this->text = $json->text;
        $this->type = $json->type;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
