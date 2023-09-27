<?php

use Carbon\Carbon;
use GmoPaymentGateway\Responses\CreditCardResponse;
use GmoPaymentGateway\Responses\TokenResponse;

it('will create transaction', function () {
    $service = getCreditCardService();
    $response = $service->entryTran([
        'orderID' => generateOrderId(),
        'jobCd' => 'CAPTURE',
        'amount' => 10000,
    ]);

    expect($response)->toBeInstanceOf(CreditCardResponse::class)
        ->and($response->data['accessID'])->not()->toBeNull()
        ->and($response->data['accessPass'])->not()->toBeNull();
});

it('will execute transaction', function () {
    $service = getCreditCardService();

    $orderId = generateOrderId();

    $entryResponse = $service->entryTran([
        'orderID' => $orderId,
        'jobCd' => 'CAPTURE',
        'amount' => 10000,
    ]);

    $execResponse = $service->execTran([
        'orderID' => $orderId,
        'memberID' => '00000003',
        'cardSeq' => 0,
        'accessID' => $entryResponse->data['accessID'],
        'accessPass' => $entryResponse->data['accessPass'],
        'method' => 1,
    ]);

    expect($execResponse)->toBeInstanceOf(CreditCardResponse::class)
        ->and($execResponse->data['approve'])->not()->toBeNull()
        ->and($execResponse->data['tranID'])->not()->toBeNull()
        ->and($execResponse->data['tranDate'])->not()->toBeNull()
        ->and($execResponse->data['checkString'])->not()->toBeNull()
        ->and($execResponse->data['acs'])->not()->toBeNull();
});

it('will alter transaction', function () {
    $service = getCreditCardService();

    $orderId = generateOrderId();

    $entryTranResponse = $service->entryTran([
        'orderID' => $orderId,
        'jobCd' => 'CAPTURE',
        'amount' => 10000,
    ]);

    $service->execTran([
        'orderID' => $orderId,
        'memberID' => '00000003',
        'cardSeq' => 0,
        'accessID' => $entryTranResponse->data['accessID'],
        'accessPass' => $entryTranResponse->data['accessPass'],
        'method' => 1,
    ]);

    $alterTranResponse = $service->alterTran([
        'accessID' => $entryTranResponse->data['accessID'],
        'accessPass' => $entryTranResponse->data['accessPass'],
        'jobCd' => 'CANCEL',
        'amount' => 10000,
    ]);

    expect($alterTranResponse)->toBeInstanceOf(CreditCardResponse::class)
        ->and($alterTranResponse->data['forward'])->not()->toBeNull()
        ->and($alterTranResponse->data['approve'])->not()->toBeNull()
        ->and($alterTranResponse->data['tranID'])->not()->toBeNull()
        ->and($alterTranResponse->data['tranDate'])->not()->toBeNull();
});

it('will change transaction amount', function () {
    $service = getCreditCardService();

    $orderId = generateOrderId();

    $entryTranResponse = $service->entryTran([
        'orderID' => $orderId,
        'jobCd' => 'CAPTURE',
        'amount' => 10000,
    ]);

    $service->execTran([
        'orderID' => $orderId,
        'memberID' => '00000003',
        'cardSeq' => 0,
        'accessID' => $entryTranResponse->data['accessID'],
        'accessPass' => $entryTranResponse->data['accessPass'],
        'method' => 1,
    ]);

    $changeTranResponse = $service->changeTran([
        'accessID' => $entryTranResponse->data['accessID'],
        'accessPass' => $entryTranResponse->data['accessPass'],
        'jobCd' => 'CAPTURE',
        'amount' => 20000,
    ]);

    expect($changeTranResponse)->toBeInstanceOf(CreditCardResponse::class)
        ->and($changeTranResponse->data['forward'])->not()->toBeNull()
        ->and($changeTranResponse->data['approve'])->not()->toBeNull()
        ->and($changeTranResponse->data['tranID'])->not()->toBeNull()
        ->and($changeTranResponse->data['tranDate'])->not()->toBeNull();
});

it('will return specified transaction', function () {
    $service = getCreditCardService();

    $orderId = 'Test-'.Carbon::now()->format('Ymdhis');

    $entryTranResponse = $service->entryTran([
        'orderID' => $orderId,
        'jobCd' => 'CAPTURE',
        'amount' => 10000,
    ]);

    $service->execTran([
        'orderID' => $orderId,
        'memberID' => '00000003',
        'cardSeq' => 0,
        'accessID' => $entryTranResponse->data['accessID'],
        'accessPass' => $entryTranResponse->data['accessPass'],
        'method' => 1,
    ]);

    $searchTranResponse = $service->searchTrade(['orderID' => $orderId]);

    expect($searchTranResponse)->toBeInstanceOf(CreditCardResponse::class)
        ->and($searchTranResponse->data['orderID'])->not()->toBeNull()
        ->and($searchTranResponse->data['status'])->not()->toBeNull()
        ->and($searchTranResponse->data['processDate'])->not()->toBeNull()
        ->and($searchTranResponse->data['accessPass'])->not()->toBeNull()
        ->and($searchTranResponse->data['itemCode'])->not()->toBeNull()
        ->and($searchTranResponse->data['amount'])->not()->toBeNull()
        ->and($searchTranResponse->data['tax'])->not()->toBeNull()
        ->and($searchTranResponse->data['siteID'])->not()->toBeNull()
        ->and($searchTranResponse->data['memberID'])->not()->toBeNull()
        ->and($searchTranResponse->data['expire'])->not()->toBeNull()
        ->and($searchTranResponse->data['method'])->not()->toBeNull()
        ->and($searchTranResponse->data['payTimes'])->not()->toBeNull()
        ->and($searchTranResponse->data['forward'])->not()->toBeNull()
        ->and($searchTranResponse->data['tranID'])->not()->toBeNull()
        ->and($searchTranResponse->data['approve'])->not()->toBeNull()
        ->and($searchTranResponse->data['forward'])->not()->toBeNull();
});

it('will return credit card token', function () {
    $service = getCreditCardService();
    $response = $service->getCreditCardToken(getConfigForCreditCardTokenHashing(), [
        'cardNo' => '4111111111111111',
        'expire' => 2312,
    ]);

    expect($response)->toBeInstanceOf(TokenResponse::class)
        ->and($response->data['tokenObject']['token'])->not()->toBeEmpty();
});
