# Deriv WebSocket API SDK

A PHP SDK for interacting with Deriv's WebSocket APIs.

## Installation

Install the package via Composer:

```bash
composer require rndwiga/deriv_apis
```

## Requirements

- PHP 8.1 or higher
- [phrity/websocket](https://github.com/sirn-se/websocket-php) package

## Quick Start

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Rndwiga\DerivApis\DerivAPI;

// Replace with your app ID from Deriv
$appId = 'YOUR_APP_ID';

// Create a new instance of the Deriv API
$api = new DerivAPI($appId);

try {
    // Get server time
    $serverTime = $api->utilities()->getServerTime();
    echo "Server time: " . json_encode($serverTime, JSON_PRETTY_PRINT) . "\n";

    // Get tick data for a symbol
    $tickData = $api->marketData()->getTicks('R_100');
    echo "Tick data for R_100: " . json_encode($tickData, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $api->disconnect();
}
```

## Available API Handlers

The SDK provides handlers for all Deriv WebSocket APIs:

- **Account** - Account management operations
- **Application** - Application management operations
- **Cashier** - Payment-related operations
- **CopyTrading** - Copy trading operations
- **EconomicCalendar** - Economic calendar events operations
- **MarketData** - Market data operations
- **MT5** - MT5 trading platform operations
- **P2P** - Peer-to-peer trading operations
- **PaymentAgent** - Payment agent operations
- **Reports** - Report generation operations
- **Trading** - Trading operations
- **Utilities** - Utility operations
- **Wallet** - Cryptocurrency wallet operations

## Authentication

For authenticated requests, you need to provide an API token:

```php
// Create an authenticated API instance
$api = new DerivAPI($appId, 'YOUR_API_TOKEN');

// Get account balance (requires authentication)
$balance = $api->account()->getBalance();
```

## Examples

See the `examples` directory for more usage examples.

## API Reference

### Account API

```php
$api->account()->getAccountInfo();
$api->account()->getSettings();
$api->account()->setSettings($settings);
$api->account()->getLimits();
$api->account()->getBalance($account);
$api->account()->getSelfExclusion();
$api->account()->setSelfExclusion($params);
$api->account()->authorize($token);
$api->account()->logout();
```

For detailed documentation on using the Account API, see the [Account API Guide](docs/account-api-guide.md).

### Market Data API

```php
$api->marketData()->getTicks($symbol, $count);
$api->marketData()->subscribeTicks($symbol);
$api->marketData()->getCandles($symbol, $count, $granularity);
$api->marketData()->subscribeCandles($symbol, $granularity);
$api->marketData()->getPriceProposal($contractParams);
$api->marketData()->subscribePriceProposal($contractParams);
$api->marketData()->getActiveSymbols($productType);
$api->marketData()->getSymbolDetails($symbol);
$api->marketData()->getTradingTimes($date);
$api->marketData()->getServerTime();
$api->marketData()->cancelSubscription($id);
$api->marketData()->cancelAllSubscriptions($type);
```

### Trading API

```php
$api->trading()->buyContract($contractParams);
$api->trading()->sellContract($contractId, $price);
$api->trading()->getContractInfo($contractId);
$api->trading()->subscribeContractInfo($contractId);
$api->trading()->getPriceProposal($contractParams);
$api->trading()->subscribePriceProposal($contractParams);
$api->trading()->cancelContract($contractId);
$api->trading()->getPayoutCurrencies();
$api->trading()->getContractTypes($symbol);
$api->trading()->getPriceForPayout($params);
$api->trading()->updateContract($contractId, $params);
$api->trading()->getProfitTable($params);
$api->trading()->getPortfolio($params);
```

### Cashier API

```php
$api->cashier()->getCashierInfo($verificationCode);
$api->cashier()->getDepositInfo($verificationCode);
$api->cashier()->getWithdrawalInfo($verificationCode);
$api->cashier()->getPaymentAgents($countryCode, $currency);
$api->cashier()->paymentAgentTransfer($params);
$api->cashier()->paymentAgentWithdraw($params);
$api->cashier()->transferBetweenAccounts($params);
$api->cashier()->getAccountTransferHistory($params);
$api->cashier()->getCryptoCurrenciesConfig();
$api->cashier()->getPaymentMethods($countryCode);
```

### Economic Calendar API

```php
$api->economicCalendar()->getEconomicCalendar($params);
$api->economicCalendar()->getEconomicEvent($eventId);
$api->economicCalendar()->subscribeEconomicCalendar($params);
```

### Copy Trading API

```php
$api->copyTrading()->getCopyTradingList($params);
$api->copyTrading()->startCopyTrading($traderId, $params);
$api->copyTrading()->stopCopyTrading($traderId);
$api->copyTrading()->getCopyTradingStatistics($traderId);
$api->copyTrading()->getCopyTradingHistory($params);
```

### MT5 API

```php
// Account Management
$api->mt5()->getAccountDetails($loginId);
$api->mt5()->getAccountTypes();
$api->mt5()->createAccount($params);
$api->mt5()->getAccountBalance($loginId);
$api->mt5()->setAccountSettings($loginId, $settings);

// Funds Management
$api->mt5()->deposit($loginId, $amount);
$api->mt5()->withdraw($loginId, $amount);
$api->mt5()->getTransactionHistory($params);

// Password Management
$api->mt5()->passwordReset($loginId, $passwordType);
$api->mt5()->passwordChange($loginId, $passwordType, $oldPassword, $newPassword);

// Trading Operations
$api->mt5()->getMT5TradeHistory($params);
$api->mt5()->getMT5OpenPositions($params);
$api->mt5()->placeMT5Order($params);
$api->mt5()->modifyMT5Order($orderId, $params);
$api->mt5()->closeMT5Position($positionId, $params);
```

For more details on available methods and parameters, refer to the [Deriv API Documentation](https://developers.deriv.com/docs).

### Copy Trading API

```php
$api->copyTrading()->getCopyTradingList($params);
$api->copyTrading()->startCopyTrading($traderId, $params);
$api->copyTrading()->stopCopyTrading($traderId);
$api->copyTrading()->getCopyTradingStatistics($traderId);
$api->copyTrading()->getCopyTradingHistory($params);
```

### Wallet API

```php
$api->wallet()->getWalletAccounts();
$api->wallet()->createWalletAccount($params);
$api->wallet()->getWalletTransactions($walletId, $params);
$api->wallet()->transferBetweenWallets($params);
```

### Payment Agent API

```php
$api->paymentAgent()->getPaymentAgents($countryCode, $currency);
$api->paymentAgent()->paymentAgentTransfer($params);
$api->paymentAgent()->paymentAgentWithdraw($params);
```

## Payment Agent Guide

Payment agents are individuals or companies that process deposits and withdrawals for Deriv clients in regions where traditional payment methods aren't available. This SDK provides functionality for payment agents to transfer funds to authorized users.

### Authentication Requirements

To perform payment agent operations, you must:

1. Have a payment agent account with Deriv
2. Generate an API token with the appropriate permissions:
   - Go to your Deriv account > Security & Limits > API Token
   - Create a token with "Admin" or "Payment" scope
   - Use this token when initializing the SDK

```php
// Initialize with payment agent token
$api = new DerivAPI($appId, 'YOUR_PAYMENT_AGENT_TOKEN');
```

### Transferring Funds to Users

Payment agents can transfer funds to authorized users using the `paymentAgentTransfer` method:

```php
$transferResult = $api->cashier()->paymentAgentTransfer([
    'amount' => 100.50,              // Amount to transfer (required)
    'currency' => 'USD',             // Currency code (required)
    'transfer_to' => 'CR12345',      // Client account ID/username (required)
    'description' => 'Fund transfer' // Description of the transfer (optional)
]);
```

#### Required Parameters:

- `amount`: The amount to transfer (numeric)
- `currency`: The currency code (string)
- `transfer_to`: The client's account ID or username (string)

#### Optional Parameters:

- `description`: A description of the transfer (string)

### Error Handling

Payment agent transfers can fail for various reasons, such as insufficient balance or invalid client ID. Always implement proper error handling:

```php
try {
    $transferResult = $api->cashier()->paymentAgentTransfer([
        'amount' => 100.50,
        'currency' => 'USD',
        'transfer_to' => 'CR12345'
    ]);
    // Process successful transfer
} catch (Exception $e) {
    // Handle error
    echo "Transfer failed: " . $e->getMessage();
}
```

### Tracking Transfers

You can track payment agent transfers using the Reports API:

```php
$transferHistory = $api->reports()->getStatement([
    'action_type' => 'paymentagent_transfer',
    'limit' => 5
]);
```

For a complete working example, see the `examples/payment_agent_example.php` file.

## Testing

This package includes comprehensive tests to ensure all functionality works as expected. The tests are written using [Pest PHP](https://pestphp.com/), a testing framework built on top of PHPUnit with a more expressive syntax.

### Running Tests

To run the tests, use the following command:

```bash
./vendor/bin/pest
```

### Available Tests

The package includes tests for the following API handlers:

- **Account** - Tests for all account management operations
- **CopyTrading** - Tests for copy trading operations
- **MT5** - Tests for MT5 trading platform operations
- **Wallet** - Tests for cryptocurrency wallet operations

### Writing Tests

If you want to contribute to the package by adding more tests, please follow the existing pattern. Each test file should:

1. Mock the DerivClient to avoid actual API calls
2. Test each method of the API handler
3. Verify that the correct parameters are passed to the sendRequest method
4. Verify that the result from sendRequest is correctly returned by the method being tested

For an example, see the [Account API tests](tests/Api/AccountTest.php).

## References

- [Deriv API Documentation](https://developers.deriv.com/docs)
- [Deriv API Playground](https://api.deriv.com/api-explorer)

## License

This package is open-sourced software licensed under the MIT license.
