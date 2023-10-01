<?php

namespace SaiMyoSett\GmoPaymentGateway\Responses;

/**
 * Class CreditCardResponse.
 */
class CreditCardResponse extends BaseResponse
{
    /**
     * @var string 取引ID | Transaction ID
     */
    public $accessID;

    /**
     * @var string 取引パスワード | Transaction Password
     */
    public $accessPass;

    /**
     * @var string ACS呼出判定 | ACS call judgment
     */
    public $acs;

    /**
     * @var string オーダーID | Order ID
     */
    public $orderID;

    /**
     * @var string 仕向先コード | Destination code
     */
    public $forward;

    /**
     * @var string 支払方法 | Payment Method
     */
    public $method;

    /**
     * @var string 支払回数 | Number Of Payments
     */
    public $payTimes;

    /**
     * @var string 承認番号 | Approval number
     */
    public $approve;

    /**
     * @var string トランザクションID | Transaction ID
     */
    public $tranID;

    /**
     * @var string 決済日付 | Settlement date
     */
    public $tranDate;

    /**
     * @var string MD5ハッシュ | MD5 hash
     */
    public $checkString;

    /**
     * @var string 現状態 | Current state
     */
    public $status;

    /**
     * @var string 処理日時 | Processing Date And Time
     */
    public $processDate;

    /**
     * @var string 処理区分 | Processing Division
     */
    public $jobCd;

    /**
     * @var string 商品コード | Product Code
     */
    public $itemCode;

    /**
     * @var string 利用金額 | Amount
     */
    public $amount;

    /**
     * @var string 税送料 | Tax
     */
    public $tax;

    /**
     * @var string サイトID | Site ID
     */
    public $siteID;

    /**
     * @var string 会員ID | Member ID
     */
    public $memberID;

    /**
     * @var string カード番号 | Card Number
     */
    public $cardNo;

    /**
     * @var string 有効期限 | Date Of Expiry
     */
    public $expire;
}
