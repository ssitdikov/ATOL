<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

use DateTime;
use Exception;
use stdClass;

/**
 * Class TokenResponse.
 *
 * @package SSitdikov\ATOL\Response
 *
 * @author  Salavat Sitdikov <sitsalavat@gmail.com>
 */
class TokenResponse implements ResponseInterface
{
    /**
     * @var array|null $error
     */
    private $error;

    /**
     * @var string $token
     */
    private $token;

    /**
     * @var DateTime $timestamp
     */
    private $timestamp;


    /**
     * TokenResponse constructor.
     *
     * @param stdClass $json
     *
     * @throws Exception
     */
    public function __construct(stdClass $json)
    {
        $this->error        = $json->error;
        $this->token        = $json->token;
        $this->timestamp    = new DateTime($json->timestamp);
    }


    /**
     * @return array|null
     */
    public function getError(): ?array
    {
        return $this->error;
    }


    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }


    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }
}
