<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Cashier APIs
 * @see https://developers.deriv.com/docs/cashier-apis
 */
class Cashier extends BaseApi
{
    /**
     * Get cashier information
     *
     * @param string $verificationCode Verification code (if required)
     * @return array
     */
    public function getCashierInfo($verificationCode = null)
    {
        $params = ['cashier' => 'info'];

        if ($verificationCode) {
            $params['verification_code'] = $verificationCode;
        }

        return $this->sendRequest($params);
    }

    /**
     * Get deposit information
     *
     * @param string $verificationCode Verification code (if required)
     * @return array
     */
    public function getDepositInfo($verificationCode = null)
    {
        $params = ['cashier' => 'deposit'];

        if ($verificationCode) {
            $params['verification_code'] = $verificationCode;
        }

        return $this->sendRequest($params);
    }

    /**
     * Get withdrawal information
     *
     * @param string $verificationCode Verification code (if required)
     * @return array
     */
    public function getWithdrawalInfo($verificationCode = null)
    {
        $params = ['cashier' => 'withdraw'];

        if ($verificationCode) {
            $params['verification_code'] = $verificationCode;
        }

        return $this->sendRequest($params);
    }

    /**
     * Transfer funds between accounts
     *
     * @param array $params Transfer parameters
     * @return array
     */
    public function transferBetweenAccounts(array $params)
    {
        return $this->sendRequest(array_merge(
            ['transfer_between_accounts' => 1],
            $params
        ));
    }

    /**
     * Get account transfer history
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getAccountTransferHistory(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['account_transfer_history' => 1],
            $params
        ));
    }

    /**
     * Get crypto currencies config
     *
     * @return array
     */
    public function getCryptoCurrenciesConfig()
    {
        return $this->sendRequest([
            'crypto_config' => 1
        ]);
    }

    /**
     * Get payment methods for a country
     *
     * @param string $countryCode Country code
     * @return array
     */
    public function getPaymentMethods($countryCode)
    {
        return $this->sendRequest([
            'payment_methods' => 1,
            'country' => $countryCode
        ]);
    }
}
