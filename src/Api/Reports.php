<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Reports APIs
 * @see https://developers.deriv.com/docs/reports-apis
 */
class Reports extends BaseApi
{
    /**
     * Get account statement
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getStatement(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['statement' => 1],
            $params
        ));
    }

    /**
     * Get profit table
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getProfitTable(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['profit_table' => 1],
            $params
        ));
    }

    /**
     * Get details of a transaction
     *
     * @param string $contractId Contract ID
     * @return array
     */
    public function getTransactionDetails($contractId)
    {
        return $this->sendRequest([
            'transaction_details' => $contractId
        ]);
    }

    /**
     * Get financial assessment details
     *
     * @return array
     */
    public function getFinancialAssessment()
    {
        return $this->sendRequest([
            'get_financial_assessment' => 1
        ]);
    }

    /**
     * Set financial assessment details
     *
     * @param array $params Financial assessment parameters
     * @return array
     */
    public function setFinancialAssessment(array $params)
    {
        return $this->sendRequest(array_merge(
            ['set_financial_assessment' => 1],
            $params
        ));
    }

    /**
     * Get trading durations
     *
     * @return array
     */
    public function getTradingDurations()
    {
        return $this->sendRequest([
            'trading_durations' => 1
        ]);
    }

    /**
     * Get account status
     *
     * @return array
     */
    public function getAccountStatus()
    {
        return $this->sendRequest([
            'get_account_status' => 1
        ]);
    }

    /**
     * Get portfolio
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getPortfolio(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['portfolio' => 1],
            $params
        ));
    }

    /**
     * Subscribe to transaction stream
     *
     * @return array
     */
    public function subscribeTransactions()
    {
        return $this->sendRequest([
            'transaction' => 1,
            'subscribe' => 1
        ]);
    }

    /**
     * Get open positions
     *
     * @return array
     */
    public function getOpenPositions()
    {
        return $this->sendRequest([
            'proposal_open_contract' => 1,
            'subscribe' => 1
        ]);
    }

    /**
     * Get limits and self-exclusion settings
     *
     * @return array
     */
    public function getLimitsAndSelfExclusion()
    {
        return $this->sendRequest([
            'get_limits' => 1,
            'get_self_exclusion' => 1
        ]);
    }
}