<?php

namespace SaiMyoSett\GmoPaymentGateway\Responses;

use SaiMyoSett\GmoPaymentGateway\Errors;

/**
 * Class ErrorResponse.
 */
class ErrorResponse extends BaseResponse
{
    /** @var array|null */
    public $errors;

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    public function interpretErrors(): void
    {
        $result = [];

        foreach ($this->errors as $error) {
            $result[] = [
                'code' => $error['errInfo'],
                'message' => Errors::getDescription($error['errInfo']),
            ];
        }

        $this->errors = $result;
    }
}
