<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Trading APIs
 * @see https://developers.deriv.com/docs/trading-apis
 */
class Trading extends BaseApi
{
    /**
     * Buy a contract
     *
     * @param array $contractParams Contract parameters
     * @return array
     */
    public function buyContract(array $contractParams)
    {
        return $this->sendRequest(array_merge(
            ['buy' => 1],
            $contractParams
        ));
    }

    /**
     * Sell a contract
     *
     * @param string $contractId Contract ID
     * @param float|null $price Price at which to sell (optional)
     * @return array
     */
    public function sellContract($contractId, $price = null)
    {
        $params = ['sell' => $contractId];
        
        if ($price !== null) {
            $params['price'] = $price;
        }
        
        return $this->sendRequest($params);
    }

    /**
     * Get details of a purchased contract
     *
     * @param string $contractId Contract ID
     * @return array
     */
    public function getContractInfo($contractId)
    {
        return $this->sendRequest([
            'proposal_open_contract' => 1,
            'contract_id' => $contractId
        ]);
    }

    /**
     * Subscribe to updates for a purchased contract
     *
     * @param string $contractId Contract ID
     * @return array
     */
    public function subscribeContractInfo($contractId)
    {
        return $this->sendRequest([
            'proposal_open_contract' => 1,
            'contract_id' => $contractId,
            'subscribe' => 1
        ]);
    }

    /**
     * Get price proposal for a contract
     *
     * @param array $contractParams Contract parameters
     * @return array
     */
    public function getPriceProposal(array $contractParams)
    {
        return $this->sendRequest(array_merge(
            ['proposal' => 1],
            $contractParams
        ));
    }

    /**
     * Subscribe to price proposal updates
     *
     * @param array $contractParams Contract parameters
     * @return array
     */
    public function subscribePriceProposal(array $contractParams)
    {
        return $this->sendRequest(array_merge(
            ['proposal' => 1, 'subscribe' => 1],
            $contractParams
        ));
    }

    /**
     * Cancel a contract (for contracts that support cancellation)
     *
     * @param string $contractId Contract ID
     * @return array
     */
    public function cancelContract($contractId)
    {
        return $this->sendRequest([
            'cancel' => $contractId
        ]);
    }

    /**
     * Get payout currencies available for trading
     *
     * @return array
     */
    public function getPayoutCurrencies()
    {
        return $this->sendRequest([
            'payout_currencies' => 1
        ]);
    }

    /**
     * Get contract types available for a symbol
     *
     * @param string $symbol Symbol name
     * @return array
     */
    public function getContractTypes($symbol)
    {
        return $this->sendRequest([
            'contracts_for' => $symbol
        ]);
    }

    /**
     * Get price based on payout
     *
     * @param array $params Price calculation parameters
     * @return array
     */
    public function getPriceForPayout(array $params)
    {
        return $this->sendRequest(array_merge(
            ['price' => 1],
            $params
        ));
    }

    /**
     * Update a contract (used for P2P contracts)
     *
     * @param string $contractId Contract ID
     * @param array $params Update parameters
     * @return array
     */
    public function updateContract($contractId, array $params)
    {
        return $this->sendRequest(array_merge(
            ['contract_update' => $contractId],
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
     * Get portfolio of open positions
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
}