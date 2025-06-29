<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Copy Trading APIs
 * @see https://developers.deriv.com/docs/copy-trading
 */
class CopyTrading extends BaseApi
{
    /**
     * Get a list of traders available for copying
     *
     * @param array $params Filter parameters
     * @return array
     */
    public function getCopyTradingList(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['copy_trading_list' => 1],
            $params
        ));
    }

    /**
     * Start copying trades from a specific trader
     *
     * @param string $traderId Trader ID to copy
     * @param array $params Additional parameters (e.g., max_amount, assets, etc.)
     * @return array
     */
    public function startCopyTrading($traderId, array $params = [])
    {
        return $this->sendRequest(array_merge(
            [
                'copy_start' => 1,
                'trader_id' => $traderId
            ],
            $params
        ));
    }

    /**
     * Stop copying trades from a specific trader
     *
     * @param string $traderId Trader ID to stop copying
     * @return array
     */
    public function stopCopyTrading($traderId)
    {
        return $this->sendRequest([
            'copy_stop' => 1,
            'trader_id' => $traderId
        ]);
    }

    /**
     * Get statistics for a specific copy trading relationship
     *
     * @param string $traderId Trader ID
     * @return array
     */
    public function getCopyTradingStatistics($traderId)
    {
        return $this->sendRequest([
            'copy_trading_statistics' => 1,
            'trader_id' => $traderId
        ]);
    }

    /**
     * Get history of copied trades
     *
     * @param array $params Filter parameters (e.g., date_from, date_to, etc.)
     * @return array
     */
    public function getCopyTradingHistory(array $params = [])
    {
        return $this->sendRequest(array_merge(
            ['copy_trading_history' => 1],
            $params
        ));
    }
}