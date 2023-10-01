<?php

namespace SaiMyoSett\GmoPaymentGateway\API;

/**
 * Class ApiResponse.
 */
class ApiResponse
{
    /**
     * @var null|array
     */
    public $headers;

    /**
     * @var null|array
     */
    public $body;

    /**
     * @var string
     */
    public $json;

    /**
     * @var int
     */
    public $code;

    /**
     * @param  string  $body  the HTTP body as a string
     * @param  int  $code  the HTTP status code
     * @param  null|array  $headers  the HTTP headers array
     * @param  null|array  $json  the JSON deserialized body
     */
    public function __construct($headers, $body, $json, $code)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->json = $json;
        $this->code = $code;
    }
}
