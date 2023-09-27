# GMO-PAYMENT-GATEWAY-PHP

- [Introduction](#introduction)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Response](#response)
    - [Success Response](#success-response)
    - [Error Response](#error-response)
- [Member and Credit Card Registration](#member-and-credit-card-registration)
    - [Create Member](#create-member)
    - [Update Member](#update-member)
    - [Search Member](#search-member)
    - [Delete Member](#delete-member)
    - [Save Credit Card](#save-credit-card)
    - [Save Traded Credit Card](#save-traded-credit-card)
    - [Search Credit Card](#search-credit-card)
    - [Search Credit Card Detail](#search-credit-card-detailh)
    - [Delete Credit Card](#delete-credit-card)
- [Credit Card Payment](#member-and-credit-card-registration)
    - [Create Transaction](#create-transaction)
    - [Execute Transaction](#execute-transaction)
    - [Change Transaction](#change-transaction)
    - [Search Transaction](#search-transaction)
- [Project Roadmap](#project-roadmap)

## Introduction

GMO-PAYMENT-GATEWAY-PHP provides an expressive and fluent interface for
accessing [GMO PAYMENT GATEWAY](https://www.gmo-pg.com/)
payment services. While using GMO-PAYMENT-GATEWAY-PHP, we recommend reviewing
the [GMO PAYMENT GATEWAY API Documentation](https://docs.mul-pay.jp/).

## Installation

```shell
composer require saimyosett/gmo-payment-gateway-php
```

## API Response

### Success Response

```php
GmoPaymentGateway\API\{Service}Response {
    +success: true,
    +data: [
      "memberID" => "00000001",
      "memberName" => "Member Name",
      "deleteFlag" => "0",
    ],
    +errors: [],
  }
```

### Error Response

```php
GmoPaymentGateway\API\ErrorResponse {
    +errors: [
      [
        "code" => "E01390002",
        "message" => "指定されたサイトIDと会員IDの会員が存在しません。",
      ],
    ],
    +"success": false,
    +"data": [],
  }
```

## Usage

```php
use GmoPaymentGateway\GMOPGClient;

$gmopg = new GmoPaymentGateway\GMOPGClient([
    "siteID"   => "Site ID",
    "sitePass" => "Site Password",
    "shopID"   => "Shop ID",
    "shopPass" => "Shop Password",
]);
```

### Member and Credit Card Registration

### Create Member

```php
$gmopg->member->create(['memberID' => 'memberID']);
```

### Update Member

```php
$gmopg->member->update([
    'memberID' => 'memberID',
    'memberName' => 'member name',
]);
```

### Search Member

```php
$gmopg->member->search(['memberID' => 'memberID']);
```

### Delete Member

```php
$gmopg->member->delete(['memberID' => 'memberID']);
```

### Save Credit Card

```php
$gmopg->member->saveCard([
    'memberID' => 'memberID',
    'cardNo'   => '4111111111111111',
    'expire'   => '0000',
]);
```

### Save Traded Credit Card

```php
$gmopg->member->tradedCard([
    'memberID' => 'memberID',
    'orderID'  => 'orderID',
    
]);
```

### Search Credit Card

```php
$gmopg->member->searchCard([
    'memberID' => 'memberID',
    'orderID'  => 'orderID',
]);
```

### Search Credit Card detail

```php
# using card number
$gmopg->member->searchCardDetail([
    'cardNo' => '4111111111111111',
]);

# using token
$gmopg->member->searchCardDetail([
    'token' => 'token',
]);
```

### Delete Credit Card

```php
$gmopg->member->deleteCard([
    'memberID' => 'memberID',
    'cardSeq'  => '0000'
]);
```

For further information on how to register Members and Credit Cards, please refer to
the [GMO PAYMENT GATEWAY API Documentation](https://docs.mul-pay.jp/payment/credit/apimember)

## Credit Card Payment

### Create Transaction

```php
$gmopg->creditCard->entryTran([
    'orderID' => 'TEST-1234'
    'jobCd'   => 'CAPTURE',
    'amount'  => 10000,
]);
```

### Execute Transaction

```php
$gmopg->creditCard->execTran([
    'orderID' => 'orderID'
    'jobCd'   => 'CAPTURE',
    'amount'  => 10000,
    'memberID'   => '00000003',
    'cardSeq'    => 0,
    'accessID'   => '8867bfeec7b7fc35f78320d01c9a6c11',
    'accessPass' => 'c07822acefba90d95417ae37beb198dd',
    'method'     => 1,
]);
```

### Change Transaction

```php
$gmopg->creditCard->alterTran([
    'accessID'   => '8867bfeec7b7fc35f78320d01c9a6c11',
    'accessPass' => 'c07822acefba90d95417ae37beb198dd',
    'amount'     => 10000,
    'jobCd'      => 'CANCEL',
]);
```

### Search Transaction

```php
$gmopg->creditCard->searchTrade([
    'orderID' => 'orderID'
]);
```

For information on how to make Credit Cards payment, please refer to
the [GMO PAYMENT GATEWAY API Documentation](https://docs.mul-pay.jp/payment/credit/api)

## GMO PAYMENT GATEWAY API Documentation

We cannot provide the documentation of GMO PAYMENT GATEWAY due to a non-disclosure agreement.
You can obtain the document after signing a non-disclosure agreement
with [GMO PAYMENT GATEWAY API Documentation](https://docs.mul-pay.jp/)

## License

GMO-PAYMENT-GATEWAY-PHP is open-sourced software licensed under the [MIT license](LICENSE.md).

## Project Roadmap

- [x] Member and Credit Card Registration API
- [x] Credit Card Payment API
- [ ] Multi-Currency Credit Card Payment (DCC) API
- [ ] Convenience Store Payment API






