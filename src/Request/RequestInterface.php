<?php

namespace SSitdikov\ATOL\Request;

interface RequestInterface
{

    const POST = 'POST';
    const GET = 'GET';

    public function getMethod();

    public function getParams();

    public function getUrl();

    public function getResponse($response);
}
