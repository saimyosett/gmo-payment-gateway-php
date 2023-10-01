<?php

namespace SaiMyoSett\GmoPaymentGateway\Services;

use SaiMyoSett\GmoPaymentGateway\Responses\BaseResponse;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    /**
     * @var \SaiMyoSett\GmoPaymentGateway\GMOPGClientInterface
     */
    protected $client;

    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param  \SaiMyoSett\GmoPaymentGateway\GMOPGClientInterface  $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \SaiMyoSett\GmoPaymentGateway\GMOPGClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    abstract public function response(): BaseResponse;

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param  null|array  $params
     */
    private static function formatParams($params)
    {
        if ($params === null) {
            return null;
        }

        array_walk_recursive($params, function (&$value, $key) {
            if ($value === null) {
                $value = '';
            }
        });

        return $params;
    }

    protected function request($path, $params)
    {
        return $this->getClient()->request($this, $path, self::formatParams($params));
    }
}
