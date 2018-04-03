<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Response;

/**
 * Interface ResponseInterface
 * @package SSitdikov\ATOL\Response
 */
interface ResponseInterface
{
    /**
     * ResponseInterface constructor.
     * @param \stdClass $json
     */
    public function __construct(\stdClass $json);
}
