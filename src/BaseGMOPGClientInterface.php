<?php

namespace GmoPaymentGateway;

/**
 * Interface for a GMOPG client.
 */
interface BaseGMOPGClientInterface
{
    /**
     * Gets the base URL for GMOPG's API.
     *
     * @return string the base URL for GMOPG's API
     */
    public function getApiBase();
}
