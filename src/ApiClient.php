<?php

namespace SSitdikov\ATOL;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SSitdikov\ATOL\Request\RequestInterface;

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

}