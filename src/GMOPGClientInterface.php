<?php

namespace SaiMyoSett\GmoPaymentGateway;

use SaiMyoSett\GmoPaymentGateway\Services\AbstractService;

/**
 * Interface for a GMOPG client.
 */
interface GMOPGClientInterface extends BaseGMOPGClientInterface
{
    /**
     * Sends a request to GMOPG's API.
     *
     * @param  string  $path  the path of the request
     * @param  array  $params  the parameters of the request
     * @return \SaiMyoSett\GmoPaymentGateway\Responses\BaseResponse the response returned by GMOPG's API
     */
    public function request(AbstractService $service, $path, $params);
}
