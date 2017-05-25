<?php

namespace SSitdikov\ATOL;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Request\GetTokenRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\SellOperationRequest;
use SSitdikov\ATOL\Response\GetTokenResponse;
use SSitdikov\ATOL\Response\ResponseInterface;
use SSitdikov\ATOL\Response\SellOperationResponse;

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
     * @return mixed
     */
    public function makeRequest(RequestInterface $request){
        try {
            $response = $this->http->request($request->getMethod(), $request->getUrl(), $request->getParams());
        } catch (ClientException $e){
            $response = $e->getResponse();
        } catch (ServerException $e){
            $response = $e->getResponse();
        }
        return $request->getResponse( $response->getBody()->getContents() );
    }

    /**
     * @param GetTokenRequest $request
     * @return GetTokenResponse
     */
    public function getToken(GetTokenRequest $request){
        return $this->makeRequest($request);
    }

    /**
     * @param SellOperationRequest $request
     * @return SellOperationResponse
     */
    public function sellOperation(SellOperationRequest $request){
        return $this->makeRequest($request);
    }

}