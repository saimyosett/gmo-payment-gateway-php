<?php

namespace GmoPaymentGateway\Responses;

use GmoPaymentGateway\Errors;

/**
 * Class TokenErrorResponse.
 */
class TokenErrorResponse extends BaseResponse
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

        foreach ($this->errors['resultCode'] as $error) {
            $result[] = [
                'code' => $error,
                'message' => Errors::getDescription($error),
            ];
        }

        $this->errors = $result;
    }
}
