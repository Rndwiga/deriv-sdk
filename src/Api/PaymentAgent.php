<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Payment Agent APIs
 * @see https://developers.deriv.com/docs/payment-agent
 */
class PaymentAgent extends BaseApi
{
    /**
     * Get payment agent list
     *
     * @param string $countryCode Country code
     * @param string $currency Currency code
     * @return array
     * @see https://api.deriv.com/api-explorer/#paymentagent_list
     */
    public function getPaymentAgents($countryCode, $currency)
    {
        return $this->sendRequest([
            'paymentagent_list' => $countryCode,
            'currency' => $currency
        ]);
    }

    /**
     * Get payment agent details
     *
     * @return array
     * @see https://api.deriv.com/api-explorer/#paymentagent_details
     */
    public function getPaymentAgentDetails()
    {
        return $this->sendRequest([
            'paymentagent_details' => 1
        ]);
    }

    /**
     * Create payment agent
     *
     * @param array $params Payment agent creation parameters
     * @return array
     * @see https://api.deriv.com/api-explorer/#paymentagent_create
     */
    public function createPaymentAgent(array $params)
    {
        return $this->sendRequest(array_merge(
            ['paymentagent_create' => 1],
            $params
        ));
    }

    /**
     * Get payment agent withdrawal justification
     *
     * @return array
     * @see https://api.deriv.com/api-explorer/#paymentagent_withdraw_justification
     */
    public function getWithdrawJustification()
    {
        return $this->sendRequest([
            'paymentagent_withdraw_justification' => 1
        ]);
    }

    /**
     * Transfer funds to a payment agent
     *
     * @param array $params Transfer parameters
     * @return array
     */
    public function paymentAgentTransfer(array $params)
    {
        return $this->sendRequest(array_merge(
            ['paymentagent_transfer' => 1],
            $params
        ));
    }

    /**
     * Withdraw through a payment agent
     *
     * @param array $params Withdrawal parameters
     * @return array
     */
    public function paymentAgentWithdraw(array $params)
    {
        return $this->sendRequest(array_merge(
            ['paymentagent_withdraw' => 1],
            $params
        ));
    }
}
