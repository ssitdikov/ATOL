<?php

namespace SSitdikov\ATOL\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\ReportResponse;
use SSitdikov\ATOL\Response\TokenResponse;

class ApiClient implements IClient
{

    private $http;

    public function __construct(Client $client = null)
    {
        $this->http = $client;
        if (null === $client) {
            $this->http = new Client([
                'base_uri' => 'https://online.atol.ru/possystem/v3/',
            ]);
        }
    }

    /**
     * @param TokenRequest $request
     * @return \SSitdikov\ATOL\Response\TokenResponse
     * @throws \Exception
     * @throws \SSitdikov\ATOL\Exception\ErrorAuthBadRequestException
     * @throws \SSitdikov\ATOL\Exception\ErrorAuthGenTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException
     */
    public function getToken(TokenRequest $request): TokenResponse
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    public function makeRequest(RequestInterface $request): string
    {
        try {
            $response = $this->http->request(
                $request->getMethod(),
                $request->getUrl(),
                $request->getParams()
            );

            return $response->getBody()->getContents();
        } catch (BadResponseException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            \json_decode($response);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $response;
            }

            return \json_encode([
                'text' => $e->getResponse()->getReasonPhrase(),
                'code' => $e->getCode(),
            ]);
        }
    }

    /**
     * @param OperationRequest $request
     * @return \SSitdikov\ATOL\Response\OperationResponse
     * @throws \Exception
     * @throws \SSitdikov\ATOL\Exception\ErrorException
     * @throws \SSitdikov\ATOL\Exception\ErrorGroupCodeToTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExistExternalIdException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExpiredTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingMissingTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingNotExistTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingOperationNotSupportException
     * @throws \SSitdikov\ATOL\Exception\ErrorIsNullExternalIdException
     */
    public function doOperation(OperationRequest $request): OperationResponse
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    /**
     * @param CorrectionRequest $request
     * @return \SSitdikov\ATOL\Response\OperationResponse
     * @throws \Exception
     * @throws \SSitdikov\ATOL\Exception\ErrorException
     * @throws \SSitdikov\ATOL\Exception\ErrorGroupCodeToTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingBadRequestException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExistExternalIdException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingExpiredTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingMissingTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingNotExistTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingOperationNotSupportException
     * @throws \SSitdikov\ATOL\Exception\ErrorIsNullExternalIdException
     * @deprecated
     */
    public function doCorrection(CorrectionRequest $request): OperationResponse
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    /**
     * @param ReportRequest $request
     * @return \SSitdikov\ATOL\Response\ReportResponse
     * @throws \Exception
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingQueueException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingQueueTimeoutException
     * @throws \SSitdikov\ATOL\Exception\ErrorIncomingValidationException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateBadRequestException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateExpiredTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateMissingTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateMissingUuidException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateNotExistTokenException
     * @throws \SSitdikov\ATOL\Exception\ErrorStateNotFoundException
     */
    public function getReport(ReportRequest $request): ReportResponse
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }
}
