<?php

namespace GmoPaymentGateway\Responses;

/**
 * Class MemberResponse.
 */
class MemberResponse extends BaseResponse
{
    /**
     * @var string 会員ID | Member ID
     */
    public $memberID;

    /**
     * @var string 会員名 | Member Name
     */
    public $memberName;

    /**
     * @var string 削除フラグ | Delete Flag
     */
    public $deleteFlag;

    /**
     * @var string カード番号 | Card Number
     */
    public $cardNo;

    /**
     * @var string カード登録連番 | Card registration Serial Number
     */
    public $cardSeq;

    /**
     * @var string 有効期限 | Date Of Expire
     */
    public $expire;

    /**
     * @var string 名義人 | Holder Name
     */
    public $holderName;

    /**
     * @var string デフォルトフラグ | Default flag
     */
    public $defaultFlag;

    /**
     * @var string 国際ブランド | International Brand
     */
    public $brand;

    /**
     * @var string 国内発行フラグ | Domestic Issue Flag
     */
    public $domesticFlag;

    /**
     * @var string イシュアコード | Issuer Code
     */
    public $issuerCode;

    /**
     * @var string デビット／プリペイドフラグ | Debit/Prepaid Flag
     */
    public $debitPrepaidFlag;

    /**
     * @var string デビット／プリペイドカード発行会社名 | Debit/Prepaid Card Issuing Company Name
     */
    public $debitPrepaidIssuerName;

    /**
     * @var string 仕向先コード | Destination Code
     */
    public $forward;

    /**
     * @var string 最終仕向先コード | Final destination Code
     */
    public $forwardFinal;
}
