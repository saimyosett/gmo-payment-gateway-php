<?php

namespace SaiMyoSett\GmoPaymentGateway\HttpClient;

class Client implements ClientInterface
{
    protected static $instance;

    public static function instance()
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function requestJson($method, $absUrl, $params)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'http_errors' => false,
        ]);

        return $client->request($method, $absUrl, ['json' => $params]);
    }

    public function requestAsForm($method, $absUrl, $params)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            'http_errors' => false,
        ]);

        return $client->request($method, $absUrl, ['form_params' => $params]);
    }
}
