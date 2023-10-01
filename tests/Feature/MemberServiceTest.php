<?php

use SaiMyoSett\GmoPaymentGateway\Responses\ErrorResponse;
use SaiMyoSett\GmoPaymentGateway\Responses\MemberResponse;

it('will not create member if memberID is not passed', function () {
    $service = getMemberService();
    $response = $service->create();

    expect($response)->toBeInstanceOf(ErrorResponse::class);
});

it('create member if memberID is passed', function () {
    $service = getMemberService();
    $response = $service->create(['memberID' => generateMemberId()]);

    expect($response)->toBeInstanceOf(MemberResponse::class);
});

it('update member', function () {
    $service = getMemberService();

    $existingMember = $service->search(['memberID' => '00000003']);

    $updateResponse = $service->update([
        'memberID' => $existingMember->data['memberID'],
        'memberName' => 'Updated Name',
    ]);

    $existingMemberFresh = $service->search(['memberID' => '00000003']);

    expect($updateResponse)->toBeInstanceOf(MemberResponse::class)
        ->and($existingMemberFresh->data['memberName'])->toBe('Updated Name');
});

it('return member for specific ID', function () {
    $service = getMemberService();
    $response = $service->search(['memberID' => '00000003']);

    expect($response)->toBeInstanceOf(MemberResponse::class)
        ->and($response->data['memberID'])->not()->toBeNull();
});

it('delete member for specific ID', function () {
    $service = getMemberService();
    $createResponse = $service->create(['memberID' => generateMemberId()]);
    $deleteResponse = $service->delete(['memberID' => $createResponse->data['memberID']]);

    expect($deleteResponse)->toBeInstanceOf(MemberResponse::class)
        ->and($deleteResponse->data['memberID'])->not()->toBeNull();
});

it('save credit card with valid information', function () {
    $service = getMemberService();

    $response = $service->saveCard(
        [
            'memberID' => '00000003',
            'cardNo' => '4111111111111111',
            'expire' => '0000',
            'CardSeq' => '0',
        ]
    );

    expect($response)->toBeInstanceOf(MemberResponse::class);
});

it('will not save credit card with invalid information', function () {
    $service = getMemberService();

    $response = $service->saveCard(
        [
            'memberID' => '00000003',
            'cardNo' => '4999000000000061',
            'expire' => '0001',
        ]
    );

    expect($response)->toBeInstanceOf(ErrorResponse::class);
});

it('return credit card information for specific memberID', function () {
    $service = getMemberService();

    $response = $service->searchCard(['memberID' => '00000003']);

    expect($response)->toBeInstanceOf(MemberResponse::class)
        ->and($response->data)->toBeArray();
});

todo('return credit card detail');

it('delete credit card', function () {
    $service = getMemberService();

    $searchResponse = $service->searchCard(['memberID' => '00000003']);
    $registeredCardCount = count($searchResponse->data);
    $cardData = $searchResponse->data['0'];

    $deleteResponse = $service->deleteCard([
        'memberID' => '00000003',
        'cardSeq' => $cardData['cardSeq'],
    ]);

    $searchResponseFresh = $service->searchCard(['memberID' => '00000003']);

    expect($deleteResponse)->toBeInstanceOf(MemberResponse::class)
        ->and(count($searchResponseFresh->data))->toBe($registeredCardCount - 1);
});
