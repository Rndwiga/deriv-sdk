<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\CopyTrading;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runCopyTradingList = true;
$runStartCopyTrading = false; // Requires valid trader ID
$runStopCopyTrading = false; // Requires valid trader ID
$runCopyTradingStatistics = false; // Requires valid trader ID
$runCopyTradingHistory = true;

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new CopyTrading instance
    $copyTrading = new CopyTrading($client);

    // Authenticate with the API (required for copy trading operations)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Run examples based on feature flags
            if ($runCopyTradingList) {
                getCopyTradingList($copyTrading);
            }
            
            if ($runStartCopyTrading) {
                startCopyTrading($copyTrading);
            }
            
            if ($runStopCopyTrading) {
                stopCopyTrading($copyTrading);
            }
            
            if ($runCopyTradingStatistics) {
                getCopyTradingStatistics($copyTrading);
            }
            
            if ($runCopyTradingHistory) {
                getCopyTradingHistory($copyTrading);
            }
        }
    } else {
        echo "API token is required for copy trading operations. Please provide a valid token.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getCopyTradingList(CopyTrading $copyTrading): void
{
    echo "\n=== Get Copy Trading List ===\n";
    // Example with pagination parameters
    $params = [
        'limit' => 10,
        'offset' => 0
    ];
    
    $response = $copyTrading->getCopyTradingList($params);
    
    if (isset($response['error'])) {
        echo "Failed to get copy trading list: " . $response['error']['message'] . "\n";
    } else {
        echo "Copy trading list retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function startCopyTrading(CopyTrading $copyTrading): void
{
    echo "\n=== Start Copy Trading ===\n";
    // Replace with a valid trader ID
    $traderId = 'CR12345';
    
    // Example with additional parameters
    $params = [
        'max_amount' => 100,
        'assets' => ['forex', 'indices']
    ];
    
    $response = $copyTrading->startCopyTrading($traderId, $params);
    
    if (isset($response['error'])) {
        echo "Failed to start copy trading: " . $response['error']['message'] . "\n";
    } else {
        echo "Copy trading started successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function stopCopyTrading(CopyTrading $copyTrading): void
{
    echo "\n=== Stop Copy Trading ===\n";
    // Replace with a valid trader ID
    $traderId = 'CR12345';
    
    $response = $copyTrading->stopCopyTrading($traderId);
    
    if (isset($response['error'])) {
        echo "Failed to stop copy trading: " . $response['error']['message'] . "\n";
    } else {
        echo "Copy trading stopped successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getCopyTradingStatistics(CopyTrading $copyTrading): void
{
    echo "\n=== Get Copy Trading Statistics ===\n";
    // Replace with a valid trader ID
    $traderId = 'CR12345';
    
    $response = $copyTrading->getCopyTradingStatistics($traderId);
    
    if (isset($response['error'])) {
        echo "Failed to get copy trading statistics: " . $response['error']['message'] . "\n";
    } else {
        echo "Copy trading statistics retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getCopyTradingHistory(CopyTrading $copyTrading): void
{
    echo "\n=== Get Copy Trading History ===\n";
    // Example with date range and pagination parameters
    $params = [
        'date_from' => '2023-01-01',
        'date_to' => '2023-12-31',
        'limit' => 10,
        'offset' => 0
    ];
    
    $response = $copyTrading->getCopyTradingHistory($params);
    
    if (isset($response['error'])) {
        echo "Failed to get copy trading history: " . $response['error']['message'] . "\n";
    } else {
        echo "Copy trading history retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}