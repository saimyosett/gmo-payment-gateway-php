<?php

namespace GmoPaymentGateway\API;

use GmoPaymentGateway\GMOPG;
use GmoPaymentGateway\HttpClient\Client;
use GmoPaymentGateway\HttpClient\ClientInterface;

/**
 * Class ApiRequestor.
 */
class ApiRequestor
{
    use HandelResponse;

    /**
     * @var string
     */
    private $_apiBase;

    /**
     * @var array<string, string>
     */
    private $_apiKeys;

    /**
     * @var ClientInterface
     */
    private static $_httpClient;

    /**
     * ApiRequestor constructor.
     *
     * @param  null|string  $apiKeys
     * @param  null|string  $apiBase
     */
    public function __construct($apiKeys = [], $apiBase = null)
    {
        $this->_apiKeys = $apiKeys;

        if (! $apiBase) {
            $apiBase = GMOPG::$apiBase;
        }

        $this->_apiBase = $apiBase;
    }

    /**
     * @param  string  $url
     * @param  array  $params
     */
    public function request($url, $params): ApiResponse
    {
        $params = $params ?: [];

        [$responseBody, $statusCode, $responseHeaders] = $this->_requestRaw($url, $params);
        $json = $this->_interpretResponse($responseBody);

        return new ApiResponse($responseHeaders, $responseBody, $json, $statusCode);
    }

    /**
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    private function _requestRaw($url, $params)
    {
        [$absUrl, $params] = $this->_prepareRequest($url, $params);

        $response = $this->httpClient()->requestJson('POST', $absUrl, $params);

        return [$response, $response->getStatusCode(), $response->getHeaders()];
    }

    private function _prepareRequest($url, $params): array
    {
        $absUrl = $this->_apiBase.$url;

        $params = array_merge(
            $this->_apiKeys,
            $params
        );

        return [$absUrl, $params];
    }

    private function _interpretResponse($response)
    {
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500 || $response->getStatusCode() >= 500) {
            return $this->failureResponse($response);
        }

        return $this->successResponse($response);
    }

    /**
     * @return Client
     */
    private function httpClient()
    {
        if (! self::$_httpClient) {
            self::$_httpClient = Client::instance();
        }

        return self::$_httpClient;
    }
}
