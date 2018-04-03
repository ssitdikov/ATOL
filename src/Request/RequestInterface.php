<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Request;

use SSitdikov\ATOL\Response\ResponseInterface;

/**
 * Interface RequestInterface
 * @package SSitdikov\ATOL\Request
 */
interface RequestInterface
{

    public const POST = 'POST';
    public const GET = 'GET';

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param $response
     * @return ResponseInterface
     */
    public function getResponse($response);
}
