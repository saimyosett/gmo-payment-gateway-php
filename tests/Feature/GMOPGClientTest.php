<?php

it('throws an exception if required parameters are not passed', function ($config) {
    new \SaiMyoSett\GmoPaymentGateway\GMOPGClient($config);
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
])->throws(\SaiMyoSett\GmoPaymentGateway\Exceptions\InvalidArgumentException::class);

it('expose properties for services', function () {
    $gmopg = new \SaiMyoSett\GmoPaymentGateway\GMOPGClient([
        'siteID' => getenv('SITE_ID'),
        'sitePass' => getenv('SITE_PASS'),
        'shopID' => getenv('SHOP_ID'),
        'shopPass' => getenv('SHOP_PASS'),
    ]);

    expect($gmopg->member)->toBeInstanceOf(\SaiMyoSett\GmoPaymentGateway\Services\MemberService::class);
});
