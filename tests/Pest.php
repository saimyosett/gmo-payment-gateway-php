<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Carbon\Carbon;
use GmoPaymentGateway\GMOPGClient;
use GmoPaymentGateway\Tests\TestCase;

uses(TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getGMOPGClientInstance()
{
    return new GMOPGClient([
        'siteID' => getenv('SITE_ID'),
        'sitePass' => getenv('SITE_PASSWORD'),
        'shopID' => getenv('SHOP_ID'),
        'shopPass' => getenv('SHOP_PASSWORD'),
    ]);
}

function getConfigForCreditCardTokenHashing()
{
    return [
        'publicKey' => getenv('PUBLIC_KEY'),
        'keyHash' => getenv('KEY_HASH'),
    ];
}

function getMemberService()
{
    return getGMOPGClientInstance()->member;
}

function getCreditCardService()
{
    return getGMOPGClientInstance()->creditCard;
}

function generateMemberId($id): string
{
    return sprintf('%08d', $id);
}

function generateOrderId(): string
{
    return 'Test-'.Carbon::now()->format('Ymdhis');
}
