<?php

namespace GmoPaymentGateway\API;

trait HandelResponse
{
    private function successResponse($response): array
    {
        return [
            'result' => true,
            'data' => $this->json($response),
            'errors' => [],
        ];
    }

    private function failureResponse($response): array
    {
        return [
            'result' => false,
            'data' => [],
            'errors' => $this->json($response),
        ];
    }

    private function json($response)
    {
        return json_decode($response->getBody(), true);
    }
}
