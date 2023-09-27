<?php

namespace GmoPaymentGateway\Services;

use GmoPaymentGateway\Responses\MemberResponse;

class MemberService extends AbstractService
{
    /**
     * Create a member | 会員登録
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#savemember
     */
    public function create($params = null)
    {
        return $this->request('/payment/SaveMember.json', $params);
    }

    /**
     * Updates the specified member | 会員更新
     *
     * @param  array  $params  An associative array with 'memberID' (string) and 'memberName' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#updatemember
     */
    public function update($params = null)
    {
        return $this->request('/payment/UpdateMember.json', $params);
    }

    /**
     * Search for specified member | 会員参照
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#searchmember
     */
    public function search($params = null)
    {
        return $this->request('/payment/SearchMember.json', $params);
    }

    /**
     * Delete specified member | 会員削除
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#deletemember
     */
    public function delete($params = null)
    {
        return $this->request('/payment/DeleteMember.json', $params);
    }

    /**
     * Update credit card for specified member | カード登録/更新
     *
     * @param  array  $params
     * An associative array with 'memberID' (string) and
     * ('cardNo' (string) and 'expire' (string|YYMM) or just 'token' (string)).
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#savecard
     */
    public function saveCard($params = null)
    {
        return $this->request('/payment/SaveCard.json', $params);
    }

    /**
     * Card registration after payment | 決済後カード登録
     *
     * @param  array  $params  An associative array with 'memberID' (string) and 'orderID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#tradedcard
     */
    public function tradedCard($params = null)
    {
        return $this->request('/payment/TradedCard.json', $params);
    }

    /**
     * Search Cards for specific member | カード照会
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#searchcard
     */
    public function searchCard($params = null)
    {
        return $this->request('/payment/SearchCard.json', $params);
    }

    /**
     * Search Cards detail| カード属性照会
     *
     * ※本APIを利用するには契約が必要です。
     *
     * @param  array  $params  An associative array with 'cardNo' (string) or just 'token' (string).
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#searchcarddetail
     */
    public function searchCardDetail($params = null)
    {
        return $this->request('/payment/SearchCardDetail.json', $params);
    }

    /**
     * Delete card for specified member | カード削除
     *
     * @param  array  $params  An associative array with 'memberID' (string) and 'cardSeq' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/apimember#deletecard
     */
    public function deleteCard($params = null)
    {
        return $this->request('/payment/DeleteCard.json', $params);
    }

    public function response(): MemberResponse
    {
        return new MemberResponse();
    }
}
