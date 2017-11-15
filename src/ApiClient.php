<?php

namespace SSitdikov\ATOL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Exception\ErrorAuthWrongUserOrPasswordException;
use SSitdikov\ATOL\Request\GetTokenRequest;
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
     * @param GetTokenRequest $request
     * @return GetTokenResponse
     * @throws ErrorAuthWrongUserOrPasswordException
     * @throws Exception\ErrorAuthBadRequestException
     * @throws Exception\ErrorAuthGenTokenException
     * @throws \Exception
     */
    public function getToken(GetTokenRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
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

    public function sellOperation(SellOperationRequest $request)
    {
        return $request->getResponse(\json_decode($this->makeRequest($request)));
    }
}