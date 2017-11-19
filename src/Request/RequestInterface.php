<?php

namespace SSitdikov\ATOL\Request;

interface RequestInterface
{

    const POST = 'POST';
    const GET = 'GET';

    public function getMethod(): string;

    public function getParams(): array;

    public function getUrl(): string;

    public function getResponse($response);
}
