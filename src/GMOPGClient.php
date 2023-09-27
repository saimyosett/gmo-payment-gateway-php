<?php

namespace GmoPaymentGateway;

use GmoPaymentGateway\Services\CoreServiceFactory;
use GmoPaymentGateway\Services\CreditCardService;
use GmoPaymentGateway\Services\MemberService;

/**
 * Client used to send requests to GMOPG's API.
 *
 * @property MemberService $member
 * @property CreditCardService $creditCard
 */
class GMOPGClient extends BaseGMOPGClient
{
    /**
     * @var CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        return $this->getService($name);
    }

    public function getService($name)
    {
        if ($this->coreServiceFactory === null) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->getService($name);
    }
}
