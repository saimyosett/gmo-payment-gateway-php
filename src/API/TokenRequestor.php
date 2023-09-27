<?php

namespace GmoPaymentGateway\API;

use GmoPaymentGateway\Exceptions\InvalidArgumentException;
use GmoPaymentGateway\GMOPG;
use GmoPaymentGateway\HttpClient\Client;
use GmoPaymentGateway\HttpClient\ClientInterface;
use GmoPaymentGateway\Responses\BaseResponse;
use GmoPaymentGateway\Responses\TokenErrorResponse;
use GmoPaymentGateway\Responses\TokenResponse;
use phpseclib3\Crypt\PublicKeyLoader;

use function array_merge;

class TokenRequestor
{
    use HandelResponse;

    /**
     * @var string
     */
    private $_apiBase;

    /**
     * @var ClientInterface
     */
    protected static $_httpClient;

    const DEFAULT_CONFIG = [
        'publicKey' => null,
        'keyHash' => null,
    ];

    /** @var array<string, mixed> */
    private $config;

    /**
     * ApiRequestor constructor.
     *
     * @param  null|array  $config
     * @param  null|string  $apiBase
     */
    public function __construct($config = [], $apiBase = null)
    {
        $config = array_merge(self::DEFAULT_CONFIG, $config);

        if (! $apiBase) {
            $apiBase = GMOPG::$apiBase;
        }

        $this->validateConfig($config);

        $this->_apiBase = $apiBase;

        $this->config = $config;
    }

    /**
     * @param  string  $url
     * @param  array  $params
     */
    public function request($url, $params): BaseResponse
    {
        $params = $params ?: [];

        $encryptedData = $this->encryptCreditCard($params);

        $data = [
            'Encrypted' => $encryptedData,
            'ShopID' => GMOPG::getShopID(),
            'KeyHash' => $this->config['keyHash'],
        ];

        [$responseBody, $statusCode, $responseHeaders] = $this->_requestRaw($url, $data);
        $json = $this->_interpretResponse($responseBody);

        $apiResponse = new ApiResponse($responseHeaders, $responseBody, $json, $statusCode);

        if (! $apiResponse->json['result']) {
            $response = new TokenErrorResponse();
        } else {
            $response = new TokenResponse();
        }

        foreach ($apiResponse->json as $key => $value) {
            $response->{$key} = $value;
        }

        if ($response instanceof TokenErrorResponse) {
            $response->interpretErrors();
        } else {
            foreach (get_object_vars($response) as $key => $value) {
                if ($response->{$key} === null && ! in_array($key, ['success', 'data', 'errors'])) {
                    unset($response->{$key});
                }
            }
        }

        return $response;
    }

    /**
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    private function _requestRaw($url, $params)
    {
        $absUrl = $this->_apiBase.$url;

        $response = $this->httpClient()->requestAsForm('POST', $absUrl, $params);

        return [$response, $response->getStatusCode(), $response->getHeaders()];
    }

    private function _interpretResponse($response)
    {
        if ($this->json($response)['resultCode'][0] != '000') {
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

    private function encryptCreditCard($params): string
    {
        $key = PublicKeyLoader::load($this->config['publicKey']);

        $jsonCardData = json_encode($params);

        openssl_public_encrypt($jsonCardData, $encrypted, $key);

        return base64_encode($encrypted);
    }

    /**
     * @param  array<string, mixed>  $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig($config)
    {
        // publicKey
        if ($config['publicKey'] === null) {
            throw new InvalidArgumentException('publicKey must not be null');
        }

        if (($config['publicKey'] === '')) {
            $msg = 'publicKey cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }

        // keyHash
        if ($config['keyHash'] === null) {
            throw new InvalidArgumentException('keyHash must not be null');
        }

        if (($config['keyHash'] === '')) {
            $msg = 'keyHash cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }
    }
}
