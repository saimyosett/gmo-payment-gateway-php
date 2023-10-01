<?php

namespace SaiMyoSett\GmoPaymentGateway\HttpClient;

interface ClientInterface
{
    /**
     * @param  'delete'|'get'|'post'  $method  The HTTP method being used
     * @param  string  $absUrl  The URL being requested, including domain and protocol
     * @param  array  $params  KV pairs for parameters.
     */
    public function requestJson($method, $absUrl, $params);

    public function requestAsForm($method, $absUrl, $params);
}
