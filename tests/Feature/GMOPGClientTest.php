<?php

it('throws an exception if required parameters are not passed', function ($config) {
    new \GmoPaymentGateway\GMOPGClient($config);
})->with([
    fn () => [
        'sitePass' => getenv('SITE_PASS'),
        'shopID' => getenv('SHOP_ID'),
        'shopPass' => getenv('SHOP_PASS'),
    ],
    fn () => [
        'siteID' => getenv('SITE_ID'),
        'shopID' => getenv('SHOP_ID'),
        'shopPass' => getenv('SHOP_PASS'),
    ],
    fn () => [
        'siteID' => getenv('SITE_ID'),
        'sitePass' => getenv('SITE_PASS'),
        'shopPass' => getenv('SHOP_PASS'),
    ],
    fn () => [
        'siteID' => getenv('SITE_ID'),
        'sitePass' => getenv('SITE_PASS'),
        'shopID' => getenv('SHOP_ID'),
    ],
])->throws(\GmoPaymentGateway\Exceptions\InvalidArgumentException::class);

it('expose properties for services', function () {
    $gmopg = new \GmoPaymentGateway\GMOPGClient([
        'siteID' => getenv('SITE_ID'),
        'sitePass' => getenv('SITE_PASS'),
        'shopID' => getenv('SHOP_ID'),
        'shopPass' => getenv('SHOP_PASS'),
    ]);

    expect($gmopg->member)->toBeInstanceOf(\GmoPaymentGateway\Services\MemberService::class);
});
