<?php

namespace GmoPaymentGateway;

class GMOPG
{
    /** @var string The base URL for the GMOPG API. Default to TEST Environment */
    public static $apiBase = 'https://pt01.mul-pay.jp';

    /** @var string The GMO PG Site ID to be used for requests. */
    public static $siteID;

    /** @var string The GMOPG Site Password to be used for requests. */
    public static $sitePassword;

    /** @var string The GMOPG Shop ID to be used for requests. */
    public static $shopID;

    /** @var string The GMOPG Shop Password to be used for requests. */
    public static $shopPassword;

    const VERSION = '1.0.0';

    /**
     * @return string the Site ID used for requests
     */
    public static function getApiBase()
    {
        return self::$apiBase;
    }

    /**
     * @return string the Site ID used for requests
     */
    public static function getSiteID()
    {
        return self::$siteID;
    }

    /**
     * @return string the Site Password used for requests
     */
    public static function getSitePassword()
    {
        return self::$sitePassword;
    }

    /**
     * @return string the Shop ID used for requests
     */
    public static function getShopID()
    {
        return self::$shopID;
    }

    /**
     * @return string the Shop Password used for requests
     */
    public static function getShopPassword()
    {
        return self::$shopPassword;
    }

    /**
     * Sets the API base to be used for requests.
     *
     * @param  string  $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * Sets the Site ID to be used for requests.
     *
     * @param  string  $siteID
     */
    public static function setSiteID($siteID)
    {
        self::$siteID = $siteID;
    }

    /**
     * Sets the Site Password to be used for requests.
     *
     * @param  string  $sitePassword
     */
    public static function setSitePassword($sitePassword)
    {
        self::$sitePassword = $sitePassword;
    }

    /**
     * Sets the Shop ID to be used for requests.
     *
     * @param  string  $shopID
     */
    public static function setShopID($shopID)
    {
        self::$shopID = $shopID;
    }

    /**
     * Sets the Shop Password to be used for requests.
     *
     * @param  string  $shopPassword
     */
    public static function setShopPassword($shopPassword)
    {
        self::$shopPassword = $shopPassword;
    }
}
