<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use SSitdikov\ATOL\Request\CorrectionRequest;
use SSitdikov\ATOL\Request\OperationRequest;
use SSitdikov\ATOL\Request\ReportRequest;
use SSitdikov\ATOL\Request\RequestInterface;
use SSitdikov\ATOL\Request\TokenRequest;
use SSitdikov\ATOL\Response\OperationResponse;
use SSitdikov\ATOL\Response\ReportResponse;
use SSitdikov\ATOL\Response\TokenResponse;
use function json_decode;
use function json_encode;
use function json_last_error;

/**
 * Class ApiClient.
 *
 * @package SSitdikov\ATOL\Client
 *
 * @author  Salavat Sitdikov <sitsalavat@gmail.com>
 */
class ApiClient implements IClient
{
    private $http;

    /**
     * @var string
     */
    private $version = 'v4';


    /**
     * ApiClient constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->http = $client;
        if (null === $client) {
            $this->http = new Client(
                [
                    'base_uri' => 'https://online.atol.ru/possystem/' . $this->getVersion() . '/',
                ]
            );
        }
    }


    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }


    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }


    /**
     * @param TokenRequest $request
     *
     * @throws Exception
     * @return TokenResponse
     */
    public function getToken(TokenRequest $request): TokenResponse
    {
        return $request->getResponse(
            json_decode(
                $this->makeRequest(
                    $request
                )
            )
        );
    }


    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function makeRequest(RequestInterface $request): string
    {
        try {
            $response = $this->http->request(
                $request->getMethod(),
                $request->getUrl(),
                $request->getParams()
            );

            $message = $response->getBody()->getContents();
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response) {
                $message = $response->getBody()->getContents();
                json_decode($message);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $message = json_encode(
                        [
                            'error' => [
                                'code' => $exception->getCode(),
                                'text' => $exception->getMessage(),
                            ],
                        ]
                    );
                }
            } else {
                $message = json_encode(
                    [
                        'error' => [
                            'code' => $exception->getCode(),
                            'text' => $exception->getMessage(),
                        ],
                    ]
                );
            }
        } catch (GuzzleException $exception) {
            $message = json_encode(
                [
                    'error' => [
                        'code' => $exception->getCode(),
                        'text' => $exception->getMessage(),
                    ],
                ]
            );
        }

        return $message;
    }


    /**
     * @param OperationRequest $request
     *
     * @throws Exception
     * @return OperationResponse
     *
     */
    public function doOperation(OperationRequest $request): OperationResponse
    {
        return $request->getResponse(
            json_decode(
                $this->makeRequest(
                    $request
                )
            )
        );
    }


    public function doCorrection(CorrectionRequest $request): OperationResponse
    {
        return $request->getResponse(
            json_decode(
                $this->makeRequest(
                    $request
                )
            )
        );
    }


    /**
     * @param ReportRequest $request
     *
     * @throws Exception
     * @return ReportResponse
     */
    public function getReport(ReportRequest $request): ReportResponse
    {
        return $request->getResponse(
            json_decode(
                $this->makeRequest(
                    $request
                )
            )
        );
    }

}
