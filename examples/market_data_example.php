<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\MarketData;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runGetTicks = true;
$runSubscribeTicks = false; // Requires WebSocket connection to stay open
$runGetCandles = true;
$runSubscribeCandles = false; // Requires WebSocket connection to stay open
$runGetPriceProposal = true;
$runSubscribePriceProposal = false; // Requires WebSocket connection to stay open
$runGetActiveSymbols = true;
$runGetSymbolDetails = true;
$runGetTradingTimes = true;
$runGetServerTime = true;
$runCancelSubscription = false; // Requires an active subscription

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access (if needed)
$authenticatedAccount = new Account($client);

try {
    // Create a new MarketData instance
    $marketData = new MarketData($client);

    // Basic market data operations that don't require authentication
    getServerTime($marketData);
    
    if ($runGetActiveSymbols) {
        getActiveSymbols($marketData);
    }
    
    if ($runGetTicks) {
        getTicks($marketData);
    }
    
    if ($runGetCandles) {
        getCandles($marketData);
    }
    
    if ($runGetPriceProposal) {
        getPriceProposal($marketData);
    }
    
    if ($runGetSymbolDetails) {
        getSymbolDetails($marketData);
    }
    
    if ($runGetTradingTimes) {
        getTradingTimes($marketData);
    }

    // Authenticate with the API (if using authenticated endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Examples that require authentication and/or WebSocket connection to stay open
            if ($runSubscribeTicks) {
                subscribeTicks($marketData);
                // Sleep to allow some ticks to come in
                sleep(5);
                // Cancel the subscription
                if ($runCancelSubscription && isset($GLOBALS['ticksSubscriptionId'])) {
                    cancelSubscription($marketData, $GLOBALS['ticksSubscriptionId']);
                }
            }
            
            if ($runSubscribeCandles) {
                subscribeCandles($marketData);
                // Sleep to allow some candles to come in
                sleep(5);
                // Cancel the subscription
                if ($runCancelSubscription && isset($GLOBALS['candlesSubscriptionId'])) {
                    cancelSubscription($marketData, $GLOBALS['candlesSubscriptionId']);
                }
            }
            
            if ($runSubscribePriceProposal) {
                subscribePriceProposal($marketData);
                // Sleep to allow some proposals to come in
                sleep(5);
                // Cancel the subscription
                if ($runCancelSubscription && isset($GLOBALS['proposalSubscriptionId'])) {
                    cancelSubscription($marketData, $GLOBALS['proposalSubscriptionId']);
                }
            }
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getServerTime(MarketData $marketData): void
{
    echo "\n=== Get Server Time ===\n";
    $response = $marketData->getServerTime();
    
    if (isset($response['error'])) {
        echo "Failed to get server time: " . $response['error']['message'] . "\n";
    } else {
        echo "Server time retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getActiveSymbols(MarketData $marketData): void
{
    echo "\n=== Get Active Symbols ===\n";
    $response = $marketData->getActiveSymbols();
    
    if (isset($response['error'])) {
        echo "Failed to get active symbols: " . $response['error']['message'] . "\n";
    } else {
        echo "Active symbols retrieved successfully\n";
        echo "Total symbols: " . (isset($response['active_symbols']) ? count($response['active_symbols']) : 0) . "\n";
        // Don't print the full list as it would be too long
        echo "First few symbols: " . json_encode(array_slice($response['active_symbols'] ?? [], 0, 3), JSON_PRETTY_PRINT) . "\n";
    }
}

function getTicks(MarketData $marketData): void
{
    echo "\n=== Get Ticks ===\n";
    // Example with symbol R_100 (Volatility 100 Index)
    $symbol = 'R_100';
    $count = 5;
    $response = $marketData->getTicks($symbol, $count);
    
    if (isset($response['error'])) {
        echo "Failed to get ticks: " . $response['error']['message'] . "\n";
    } else {
        echo "Ticks retrieved successfully for symbol: $symbol\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribeTicks(MarketData $marketData): void
{
    echo "\n=== Subscribe to Ticks ===\n";
    // Example with symbol R_100 (Volatility 100 Index)
    $symbol = 'R_100';
    $response = $marketData->subscribeTicks($symbol);
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to ticks: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to ticks for symbol: $symbol\n";
        echo "Initial response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // Store subscription ID for later cancellation
        if (isset($response['subscription']['id'])) {
            $GLOBALS['ticksSubscriptionId'] = $response['subscription']['id'];
            echo "Subscription ID: " . $GLOBALS['ticksSubscriptionId'] . "\n";
        }
    }
}

function getCandles(MarketData $marketData): void
{
    echo "\n=== Get Candles ===\n";
    // Example with symbol R_100 (Volatility 100 Index)
    $symbol = 'R_100';
    $count = 5;
    $granularity = 60; // 1 minute candles
    $response = $marketData->getCandles($symbol, $count, $granularity);
    
    if (isset($response['error'])) {
        echo "Failed to get candles: " . $response['error']['message'] . "\n";
    } else {
        echo "Candles retrieved successfully for symbol: $symbol\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribeCandles(MarketData $marketData): void
{
    echo "\n=== Subscribe to Candles ===\n";
    // Example with symbol R_100 (Volatility 100 Index)
    $symbol = 'R_100';
    $granularity = 60; // 1 minute candles
    $response = $marketData->subscribeCandles($symbol, $granularity);
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to candles: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to candles for symbol: $symbol\n";
        echo "Initial response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // Store subscription ID for later cancellation
        if (isset($response['subscription']['id'])) {
            $GLOBALS['candlesSubscriptionId'] = $response['subscription']['id'];
            echo "Subscription ID: " . $GLOBALS['candlesSubscriptionId'] . "\n";
        }
    }
}

function getPriceProposal(MarketData $marketData): void
{
    echo "\n=== Get Price Proposal ===\n";
    // Example contract parameters for a simple Rise/Fall contract
    $contractParams = [
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'amount' => 10,
        'basis' => 'payout'
    ];
    
    $response = $marketData->getPriceProposal($contractParams);
    
    if (isset($response['error'])) {
        echo "Failed to get price proposal: " . $response['error']['message'] . "\n";
    } else {
        echo "Price proposal retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribePriceProposal(MarketData $marketData): void
{
    echo "\n=== Subscribe to Price Proposal ===\n";
    // Example contract parameters for a simple Rise/Fall contract
    $contractParams = [
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'amount' => 10,
        'basis' => 'payout'
    ];
    
    $response = $marketData->subscribePriceProposal($contractParams);
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to price proposal: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to price proposal\n";
        echo "Initial response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // Store subscription ID for later cancellation
        if (isset($response['subscription']['id'])) {
            $GLOBALS['proposalSubscriptionId'] = $response['subscription']['id'];
            echo "Subscription ID: " . $GLOBALS['proposalSubscriptionId'] . "\n";
        }
    }
}

function getSymbolDetails(MarketData $marketData): void
{
    echo "\n=== Get Symbol Details ===\n";
    // Example with symbol R_100 (Volatility 100 Index)
    $symbol = 'R_100';
    $response = $marketData->getSymbolDetails($symbol);
    
    if (isset($response['error'])) {
        echo "Failed to get symbol details: " . $response['error']['message'] . "\n";
    } else {
        echo "Symbol details retrieved successfully for symbol: $symbol\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getTradingTimes(MarketData $marketData): void
{
    echo "\n=== Get Trading Times ===\n";
    // Get trading times for today
    $today = date('Y-m-d');
    $response = $marketData->getTradingTimes($today);
    
    if (isset($response['error'])) {
        echo "Failed to get trading times: " . $response['error']['message'] . "\n";
    } else {
        echo "Trading times retrieved successfully for date: $today\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function cancelSubscription(MarketData $marketData, $subscriptionId): void
{
    echo "\n=== Cancel Subscription ===\n";
    $response = $marketData->cancelSubscription($subscriptionId);
    
    if (isset($response['error'])) {
        echo "Failed to cancel subscription: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscription cancelled successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function cancelAllSubscriptions(MarketData $marketData, $type): void
{
    echo "\n=== Cancel All Subscriptions ===\n";
    $response = $marketData->cancelAllSubscriptions($type);
    
    if (isset($response['error'])) {
        echo "Failed to cancel all subscriptions: " . $response['error']['message'] . "\n";
    } else {
        echo "All subscriptions of type '$type' cancelled successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}