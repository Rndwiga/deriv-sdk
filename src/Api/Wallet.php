<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Wallet APIs
 * @see https://developers.deriv.com/docs/wallet-apis
 */
class Wallet extends BaseApi
{
    /**
     * Get a list of wallet accounts
     *
     * @return array
     */
    public function getWalletAccounts()
    {
        return $this->sendRequest([
            'wallet_accounts' => 1
        ]);
    }

    /**
     * Create a new wallet account
     *
     * @param array $params Parameters for creating a wallet account
     * @return array
     */
    public function createWalletAccount(array $params)
    {
        return $this->sendRequest(array_merge(
            ['wallet_create' => 1],
            $params
        ));
    }

    /**
     * Get transactions for a specific wallet
     *
     * @param string $walletId Wallet ID
     * @param array $params Additional filter parameters
     * @return array
     */
    public function getWalletTransactions($walletId, array $params = [])
    {
        return $this->sendRequest(array_merge(
            [
                'wallet_transactions' => 1,
                'wallet_id' => $walletId
            ],
            $params
        ));
    }

    /**
     * Transfer funds between wallets
     *
     * @param array $params Transfer parameters
     * @return array
     */
    public function transferBetweenWallets(array $params)
    {
        return $this->sendRequest(array_merge(
            ['wallet_transfer' => 1],
            $params
        ));
    }
}