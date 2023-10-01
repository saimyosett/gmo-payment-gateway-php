<?php

namespace SaiMyoSett\GmoPaymentGateway\Services;

use SaiMyoSett\GmoPaymentGateway\API\TokenRequestor;
use SaiMyoSett\GmoPaymentGateway\Exceptions\InvalidArgumentException;
use SaiMyoSett\GmoPaymentGateway\GMOPG;
use SaiMyoSett\GmoPaymentGateway\Responses\CreditCardResponse;

class CreditCardService extends AbstractService
{
    /**
     * Transaction Registration | 取引登録
     *
     * @param  array  $params  An associative array with 'orderId' (string) and 'jobCd (string) and 'amount' (int)
     *
     * @see https://docs.mul-pay.jp/payment/credit/api#entryTran
     */
    public function entryTran($params = null)
    {
        return $this->request('/payment/EntryTran.json', $params);
    }

    /**
     * Charge Execution | 決済実行
     *
     * @param  array  $params  An associative array with 'accessID' (string),'accessPass' (string),
     * 'orderID' (string), 'cardNo' (string), 'expire' (string) and 'method' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/api#exectran
     */
    public function execTran($params = null)
    {
        return $this->request('/payment/ExecTran.json', $params);
    }

    /**
     * Change Payment | 決済変更
     *
     * 注意
     * 3Dセキュア（本人認証サービス）を利用した取引の場合でも、再オーソリを行った取引は3Dセキュア対象外となります
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/api#altertran
     */
    public function alterTran($params = null)
    {
        return $this->request('/payment/AlterTran.json', $params);
    }

    /**
     * Change Amount | 金額変更
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/api#changetran
     */
    public function changeTran($params = null)
    {
        return $this->request('/payment/ChangeTran.json', $params);
    }

    /**
     * Get Transaction Status | 取引状態参照
     *
     * @param  array  $params  An associative array with 'memberID' (string)
     *
     * @see https://docs.mul-pay.jp/payment/credit/api#searchtrade
     */
    public function searchTrade($params = null)
    {
        return $this->request('/payment/SearchTrade.json', $params);
    }

    /**
     * Get Credit Token
     *
     * @param  array  $config An associative array with 'publicKey' (string) and 'keyHash' (string)
     * @param  array  $params  An associative array with 'cardNo' (string) and 'expire' (string)
     */
    public function getCreditCardToken($config = [], $params = [])
    {
        // cardNo
        if ($params['cardNo'] === null) {
            throw new InvalidArgumentException('cardNo must not be null');
        }

        // expire
        if ($params['expire'] === null) {
            throw new InvalidArgumentException('expire must not be null');
        }

        $requestor = new TokenRequestor($config, GMOPG::getApiBase());
        $requestorResponse = $requestor->request('/ext/api/credit/getToken', $params);

        return $requestorResponse;
    }

    public function response(): CreditCardResponse
    {
        return new CreditCardResponse();
    }
}
