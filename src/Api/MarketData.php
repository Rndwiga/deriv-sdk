<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Market Data APIs
 * @see https://developers.deriv.com/docs/market-data-apis
 */
class MarketData extends BaseApi
{
    /**
     * Get ticks for a symbol
     *
     * @param string $symbol Symbol name
     * @param int $count Number of ticks to return (optional)
     * @return array
     */
    public function getTicks($symbol, $count = 10)
    {
        return $this->sendRequest([
            'ticks' => $symbol,
            'count' => $count
        ]);
    }

    /**
     * Subscribe to ticks for a symbol
     *
     * @param string $symbol Symbol name
     * @return array
     */
    public function subscribeTicks($symbol)
    {
        return $this->sendRequest([
            'ticks' => $symbol,
            'subscribe' => 1
        ]);
    }

    /**
     * Get candles for a symbol
     *
     * @param string $symbol Symbol name
     * @param int $count Number of candles to return (optional)
     * @param string $granularity Candle interval in seconds (optional)
     * @return array
     */
    public function getCandles($symbol, $count = 10, $granularity = 60)
    {
        return $this->sendRequest([
            'candles' => $symbol,
            'count' => $count,
            'granularity' => $granularity
        ]);
    }

    /**
     * Subscribe to candles for a symbol
     *
     * @param string $symbol Symbol name
     * @param string $granularity Candle interval in seconds (optional)
     * @return array
     */
    public function subscribeCandles($symbol, $granularity = 60)
    {
        return $this->sendRequest([
            'candles' => $symbol,
            'granularity' => $granularity,
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
     * Get list of available symbols
     *
     * @param string $productType Product type (optional)
     * @return array
     */
    public function getActiveSymbols($productType = 'basic')
    {
        return $this->sendRequest([
            'active_symbols' => $productType
        ]);
    }

    /**
     * Get details of a trading symbol
     *
     * @param string $symbol Symbol name
     * @return array
     */
    public function getSymbolDetails($symbol)
    {
        return $this->sendRequest([
            'symbol_details' => $symbol
        ]);
    }

    /**
     * Get market trading times
     *
     * @param string $date Trading date in yyyy-mm-dd format (optional)
     * @return array
     */
    public function getTradingTimes($date = null)
    {
        $params = ['trading_times' => 1];
        
        if ($date) {
            $params['trading_times'] = $date;
        }
        
        return $this->sendRequest($params);
    }

    /**
     * Get server time
     *
     * @return array
     */
    public function getServerTime()
    {
        return $this->sendRequest([
            'time' => 1
        ]);
    }

    /**
     * Cancel a subscription by ID
     *
     * @param int $id Subscription ID
     * @return array
     */
    public function cancelSubscription($id)
    {
        return $this->sendRequest([
            'forget' => $id
        ]);
    }

    /**
     * Cancel all subscriptions of a specific type
     *
     * @param string $type Subscription type (ticks, candles, proposal)
     * @return array
     */
    public function cancelAllSubscriptions($type)
    {
        return $this->sendRequest([
            'forget_all' => $type
        ]);
    }
}