<?php

namespace SSitdikov\ATOL\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;

class ApiClient implements IClient
{

    private $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://online.atol.ru/possystem/v3/',
        ]);
    }

    public function makeRequest(RequestInterface $request)
    {
        try {
            $response = $this->http->request($request->getMethod(), $request->getUrl(), $request->getParams());
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            \json_decode($response);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $response;
            }
            return \json_encode(['text' => $e->getResponse()->getReasonPhrase(), 'code' => $e->getCode()]);
        } catch (ServerException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            \json_decode($response);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $response;
            }
            return \json_encode(['text' => $e->getResponse()->getReasonPhrase(), 'code' => $e->getCode()]);
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
    public function getToken(TokenRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
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
    public function doOperation(OperationRequest $request)
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
    public function doCorrection(CorrectionRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    public function getReport(ReportRequest $request)
    {

        print $request->getUrl() . PHP_EOL;
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

}
