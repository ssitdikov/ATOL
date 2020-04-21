<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Client;

use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\ReportResponse;
use SSitdikov\ATOL\Response\TokenResponse;

/**
 * Interface IClient.
 *
 * @package SSitdikov\ATOL\Client
 */
interface IClient
{
    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function makeRequest(RequestInterface $request): string;


    /**
     * @param TokenRequest $request
     *
     * @return TokenResponse
     */
    public function getToken(TokenRequest $request): TokenResponse;


    /**
     * @param OperationRequest $request
     *
     * @return OperationResponse
     */
    public function doOperation(OperationRequest $request): OperationResponse;


    /**
     * @param CorrectionRequest $request
     *
     * @return OperationResponse
     */
    public function doCorrection(CorrectionRequest $request): OperationResponse;


    /**
     * @param ReportRequest $request
     *
     * @return ReportResponse
     */
    public function getReport(ReportRequest $request): ReportResponse;
}
