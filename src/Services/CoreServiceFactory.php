<?php

namespace SaiMyoSett\GmoPaymentGateway\Services;

/**
 * Service factory class for API resources in the root namespace.
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'member' => MemberService::class,
        'creditCard' => CreditCardService::class,
    ];

    protected function getServiceClass($name)
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
