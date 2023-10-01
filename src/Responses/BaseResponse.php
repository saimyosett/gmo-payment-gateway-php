<?php

namespace SaiMyoSett\GmoPaymentGateway\Responses;

/**
 * Class BaseResponse.
 */
abstract class BaseResponse
{
    /**
     * @var bool
     */
    public $result;

    /**
     * @var null|array
     */
    public $data;

    /**
     * @var null|array
     */
    public $errors;

    public function hasErrors(): bool
    {
        return false;
    }
}
