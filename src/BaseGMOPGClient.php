<?php

namespace GmoPaymentGateway;

use GmoPaymentGateway\API\ApiRequestor;
use GmoPaymentGateway\API\ApiResponse;
use GmoPaymentGateway\Exceptions\InvalidArgumentException;
use GmoPaymentGateway\Responses\BaseResponse;
use GmoPaymentGateway\Responses\ErrorResponse;
use GmoPaymentGateway\Services\AbstractService;

use function array_merge;

class BaseGMOPGClient implements GMOPGClientInterface
{
    /** @var string default base URL for GMO Payment Gateway's API */
    const DEFAULT_API_BASE = 'https://pt01.mul-pay.jp';

    /** @var array<string, null|string> */
    const DEFAULT_CONFIG = [
        'siteID' => null,
        'sitePass' => null,
        'shopID' => null,
        'shopPass' => null,
        'apiBase' => self::DEFAULT_API_BASE,
    ];

    /** @var array<string, mixed> */
    private $config;

    /**
     * Initializes a new instance of the {@link BaseGMOPGClient} class.
     *
     * The constructor takes a single argument. The argument is an array with various configuration settings.
     *
     * Configuration settings include the following options:
     *
     * - siteID (string): the Site ID to be used in API requests.
     * - sitePass (string): the Site Password to be used in API requests.
     * - shopID (string): the Shop ID to be used in API requests.
     * - shopPass (string): the Shop Password to be used in API requests.
     * - apiBase (string): the API Base Url to be used in API requests.
     *
     * @param  array<string, string>|string  $config
     */
    public function __construct($config = [])
    {
        $config = \array_merge(self::DEFAULT_CONFIG, $config);

        if (! isset($params['apiBase'])) {
            $this->config['apiBase'] = GMOPG::getApiBase();
        }

        $this->validateConfig($config);

        GMOPG::setShopID($config['shopID']);
        GMOPG::setShopPassword($config['shopPass']);
        GMOPG::setSiteID($config['siteID']);
        GMOPG::setSitePassword($config['sitePass']);

        $this->config = $config;
    }

    /**
     * Gets the base URL for GMO's API.
     *
     * @return string the base URL for Stripe's API
     */
    public function getApiBase()
    {
        return $this->config['apiBase'];
    }

    public function getSiteInfo()
    {
        return [
            'siteID' => $this->config['siteID'],
            'sitePass' => $this->config['sitePass'],
        ];
    }

    public function getShopInfo()
    {
        return [
            'shopID' => $this->config['shopID'],
            'shopPass' => $this->config['shopPass'],
        ];
    }

    /**
     * Sends a request to GMO Payment Gateway's API.
     *
     * @param  AbstractService  $service  the service that makes the request
     * @param  string  $path  API endpoint
     * @param  array  $params  the parameters of the request
     * @return BaseResponse the object returned by GMO Payment Gateway's API
     */
    public function request(AbstractService $service, $path, $params)
    {
        $requestor = new ApiRequestor($this->apiKeysForRequest(), $this->getApiBase());
        $requestorResponse = $requestor->request($path, $this->handleParamsForGMO($params));

        return $this->convertResponse($service, $requestorResponse);
    }

    private function handleParamsForGMO($params)
    {
        if (isset($params['member_id'])) {
            $params['memberID'] = $params['member_id'];
        }

        return $params;
    }

    private function convertResponse(AbstractService $service, ApiResponse $requestorResponse)
    {
        if (! $requestorResponse->json['result']) {
            $response = new ErrorResponse();
        } else {
            $response = $service->response();
        }

        foreach ($requestorResponse->json as $key => $value) {
            $response->{$key} = $value;
        }

        if ($response instanceof ErrorResponse) {
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

    private function apiKeysForRequest(): array
    {
        return array_merge($this->getSiteInfo(), $this->getShopInfo());
    }

    /**
     * @param  array<string, mixed>  $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig($config)
    {
        // apiBase
        if ($config['apiBase'] === null) {
            throw new InvalidArgumentException('apiBase must not be null');
        }

        if (($config['apiBase'] === '')) {
            $msg = 'apiBase cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }
        // siteID
        if ($config['siteID'] === null) {
            throw new InvalidArgumentException('siteID must not be null');
        }

        if (($config['siteID'] === '')) {
            $msg = 'siteID cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }

        // sitePass
        if ($config['sitePass'] === null) {
            throw new InvalidArgumentException('sitePass must not be null');
        }

        if (($config['sitePass'] === '')) {
            $msg = 'sitePass cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }

        // shopID
        if ($config['shopID'] === null) {
            throw new InvalidArgumentException('shopID must not be null');
        }

        if (($config['shopID'] === '')) {
            $msg = 'shopID cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }

        // shopPass
        if ($config['shopPass'] === null) {
            throw new InvalidArgumentException('shopPass must not be null');
        }

        if (($config['shopPass'] === '')) {
            $msg = 'shopPass cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }
    }
}
