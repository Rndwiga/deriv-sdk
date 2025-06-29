<?php

namespace Rndwiga\DerivApis;

use Rndwiga\DerivApis\Client\DerivClient;
use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Application;
use Rndwiga\DerivApis\Api\Cashier;
use Rndwiga\DerivApis\Api\CopyTrading;
use Rndwiga\DerivApis\Api\EconomicCalendar;
use Rndwiga\DerivApis\Api\MarketData;
use Rndwiga\DerivApis\Api\MT5;
use Rndwiga\DerivApis\Api\P2P;
use Rndwiga\DerivApis\Api\PaymentAgent;
use Rndwiga\DerivApis\Api\Reports;
use Rndwiga\DerivApis\Api\Trading;
use Rndwiga\DerivApis\Api\Utilities;
use Rndwiga\DerivApis\Api\Wallet;

/**
 * Main entry point for the Deriv API SDK
 * 
 * Available API handlers:
 * - account() - Account management operations
 * - application() - Application management operations
 * - cashier() - Payment-related operations
 * - copyTrading() - Copy trading operations
 * - economicCalendar() - Economic calendar events operations
 * - marketData() - Market data operations
 * - mt5() - MT5 trading platform operations
 * - p2p() - Peer-to-peer trading operations
 * - paymentAgent() - Payment agent operations
 * - reports() - Report generation operations
 * - trading() - Trading operations
 * - utilities() - Utility operations
 * - wallet() - Cryptocurrency wallet operations
 */
class DerivAPI
{
    /**
     * @var DerivClient
     */
    private $client;

    /**
     * @var Account
     */
    private $account;

    /**
     * @var Application
     */
    private $application;

    /**
     * @var Cashier
     */
    private $cashier;

    /**
     * @var MarketData
     */
    private $marketData;

    /**
     * @var MT5
     */
    private $mt5;

    /**
     * @var P2P
     */
    private $p2p;

    /**
     * @var Reports
     */
    private $reports;

    /**
     * @var Trading
     */
    private $trading;

    /**
     * @var Utilities
     */
    private $utilities;

    /**
     * @var PaymentAgent
     */
    private $paymentAgent;

    /**
     * @var EconomicCalendar
     */
    private $economicCalendar;

    /**
     * @var CopyTrading
     */
    private $copyTrading;

    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * DerivAPI constructor
     *
     * @param string $appId Your Deriv API app ID
     * @param string|null $token Optional API token for authenticated requests
     * @param string $endpoint WebSocket endpoint URL
     */
    public function __construct(
        $appId,
        $token = null,
        $endpoint = 'wss://ws.binaryws.com/websockets/v3'
    ) {
        $this->client = new DerivClient($appId, $token, $endpoint);
    }

    /**
     * Get the Account API handler
     *
     * @return Account
     */
    public function account()
    {
        if (!$this->account) {
            $this->account = new Account($this->client);
        }

        return $this->account;
    }

    /**
     * Get the Application API handler
     *
     * @return Application
     */
    public function application()
    {
        if (!$this->application) {
            $this->application = new Application($this->client);
        }

        return $this->application;
    }

    /**
     * Get the Cashier API handler
     *
     * @return Cashier
     */
    public function cashier()
    {
        if (!$this->cashier) {
            $this->cashier = new Cashier($this->client);
        }

        return $this->cashier;
    }

    /**
     * Get the Market Data API handler
     *
     * @return MarketData
     */
    public function marketData()
    {
        if (!$this->marketData) {
            $this->marketData = new MarketData($this->client);
        }

        return $this->marketData;
    }

    /**
     * Get the MT5 API handler
     *
     * @return MT5
     */
    public function mt5()
    {
        if (!$this->mt5) {
            $this->mt5 = new MT5($this->client);
        }

        return $this->mt5;
    }

    /**
     * Get the P2P API handler
     *
     * @return P2P
     */
    public function p2p()
    {
        if (!$this->p2p) {
            $this->p2p = new P2P($this->client);
        }

        return $this->p2p;
    }

    /**
     * Get the Reports API handler
     *
     * @return Reports
     */
    public function reports()
    {
        if (!$this->reports) {
            $this->reports = new Reports($this->client);
        }

        return $this->reports;
    }

    /**
     * Get the Trading API handler
     *
     * @return Trading
     */
    public function trading()
    {
        if (!$this->trading) {
            $this->trading = new Trading($this->client);
        }

        return $this->trading;
    }

    /**
     * Get the Utilities API handler
     *
     * @return Utilities
     */
    public function utilities()
    {
        if (!$this->utilities) {
            $this->utilities = new Utilities($this->client);
        }

        return $this->utilities;
    }

    /**
     * Get the Payment Agent API handler
     *
     * @return PaymentAgent
     */
    public function paymentAgent()
    {
        if (!$this->paymentAgent) {
            $this->paymentAgent = new PaymentAgent($this->client);
        }

        return $this->paymentAgent;
    }

    /**
     * Get the Economic Calendar API handler
     *
     * @return EconomicCalendar
     */
    public function economicCalendar()
    {
        if (!$this->economicCalendar) {
            $this->economicCalendar = new EconomicCalendar($this->client);
        }

        return $this->economicCalendar;
    }

    /**
     * Get the Copy Trading API handler
     *
     * @return CopyTrading
     */
    public function copyTrading()
    {
        if (!$this->copyTrading) {
            $this->copyTrading = new CopyTrading($this->client);
        }

        return $this->copyTrading;
    }

    /**
     * Get the Wallet API handler
     *
     * @return Wallet
     */
    public function wallet()
    {
        if (!$this->wallet) {
            $this->wallet = new Wallet($this->client);
        }

        return $this->wallet;
    }

    /**
     * Close the WebSocket connection
     *
     * @return void
     */
    public function disconnect()
    {
        $this->client->disconnect();
    }
}
