<?php

namespace SSitdikov\ATOL\Client;

use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;

interface IClient
{
    public function makeRequest(RequestInterface $request);

    public function getToken(TokenRequest $request);

    public function doOperation(OperationRequest $request);

    public function doCorrection(CorrectionRequest $request);
}
