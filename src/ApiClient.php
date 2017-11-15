<?php

namespace SSitdikov\ATOL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\SellOperationRequest;
use SSitdikov\ATOL\Response\GetTokenResponse;

class ApiClient
{

    /**
     * @var Client
     */
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param RequestInterface $request
     * @return string
     */
    public function makeRequest(RequestInterface $request)
    {
        try {
            $response = $this->http->request($request->getMethod(), $request->getUrl(), $request->getParams());
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            json_decode($response);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $response;
            }
            return json_encode(['text' => $e->getResponse()->getReasonPhrase(), 'code' => $e->getCode()]);
        } catch (ServerException $e) {
            $response = $e->getResponse()->getBody()->getContents();
            json_decode($response);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $response;
            }
            return json_encode(['text' => $e->getResponse()->getReasonPhrase(), 'code' => $e->getCode()]);
        }
    }

    /**
     * @param TokenRequest $request
     * @return GetTokenResponse
     * @throws ErrorAuthWrongUserOrPasswordException
     * @throws Exception\ErrorAuthBadRequestException
     * @throws Exception\ErrorAuthGenTokenException
     * @throws \Exception
     */
    public function getToken(TokenRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    /**
     * @param OperationRequest $request
     * @return Response\OperationResponse
     * @throws Exception\ErrorException
     * @throws Exception\ErrorGroupCodeToTokenException
     * @throws Exception\ErrorIncomingBadRequestException
     * @throws Exception\ErrorIncomingExistExternalIdException
     * @throws Exception\ErrorIncomingExpiredTokenException
     * @throws Exception\ErrorIncomingMissingTokenException
     * @throws Exception\ErrorIncomingNotExistTokenException
     * @throws Exception\ErrorIncomingOperationNotSupportException
     * @throws Exception\ErrorIsNullExternalIdException
     * @throws \Exception
     */
    public function doOperation(OperationRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }

    /**
     * @param CorrectionRequest $request
     * @return Response\OperationResponse
     * @throws Exception\ErrorException
     * @throws Exception\ErrorGroupCodeToTokenException
     * @throws Exception\ErrorIncomingBadRequestException
     * @throws Exception\ErrorIncomingExistExternalIdException
     * @throws Exception\ErrorIncomingExpiredTokenException
     * @throws Exception\ErrorIncomingMissingTokenException
     * @throws Exception\ErrorIncomingNotExistTokenException
     * @throws Exception\ErrorIncomingOperationNotSupportException
     * @throws Exception\ErrorIsNullExternalIdException
     * @throws \Exception
     */
    public function doCorrection(CorrectionRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }
}
