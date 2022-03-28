<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

use stdClass;

/**
 * Class ErrorResponse.
 *
 * @package SSitdikov\ATOL\Response
 */
class ErrorResponse implements ResponseInterface
{

    /**
     * @var string
     */
    private $error_id;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $type;


    /**
     * ErrorResponse constructor.
     *
     * @param stdClass $json
     */
    public function __construct(stdClass $json)
    {
        $this->error_id = $json->error_id;
        $this->code     = $json->code;
        $this->text     = $json->text;
        $this->type     = $json->type;
    }


    /**
     * @return string
     */
    public function getErrorId(): string
    {
        return $this->error_id;
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
