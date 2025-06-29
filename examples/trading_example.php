<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Trading;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runBuyContract = true;
$runSellContract = true;
$runContractInfo = true;
$runPriceProposal = true;
$runPayoutCurrencies = true;
$runContractTypes = true;
$runPriceForPayout = true;
$runPortfolio = false; // Requires authentication
$runProfitTable = false; // Requires authentication

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new Trading instance
    $trading = new Trading($client);

    // Basic trading operations that don't require authentication
    if ($runPayoutCurrencies) {
        getPayoutCurrencies($trading);
    }
    
    if ($runContractTypes) {
        getContractTypes($trading, 'R_100');
    }
    
    // Authenticate with the API (if using authenticated endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Examples that require authentication
            if ($runBuyContract) {
                buyContractExample($trading);
            }
            
            if ($runSellContract) {
                sellContractExample($trading);
            }
            
            if ($runContractInfo) {
                getContractInfoExample($trading);
                subscribeContractInfoExample($trading);
            }
            
            if ($runPriceProposal) {
                getPriceProposalExample($trading);
                subscribePriceProposalExample($trading);
            }
            
            if ($runPriceForPayout) {
                getPriceForPayoutExample($trading);
            }
            
            if ($runPortfolio) {
                getPortfolioExample($trading);
            }
            
            if ($runProfitTable) {
                getProfitTableExample($trading);
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

function getPayoutCurrencies(Trading $trading): void
{
    echo "\n=== Get Payout Currencies ===\n";
    $response = $trading->getPayoutCurrencies();
    
    if (isset($response['error'])) {
        echo "Failed to get payout currencies: " . $response['error']['message'] . "\n";
    } else {
        echo "Payout currencies retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getContractTypes(Trading $trading, string $symbol): void
{
    echo "\n=== Get Contract Types for $symbol ===\n";
    $response = $trading->getContractTypes($symbol);
    
    if (isset($response['error'])) {
        echo "Failed to get contract types: " . $response['error']['message'] . "\n";
    } else {
        echo "Contract types retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function buyContractExample(Trading $trading): void
{
    echo "\n=== Buy Contract Example ===\n";
    // Example contract parameters for a simple Rise/Fall contract
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $response = $trading->buyContract($contractParams);
    
    if (isset($response['error'])) {
        echo "Failed to buy contract: " . $response['error']['message'] . "\n";
    } else {
        echo "Contract purchased successfully\n";
        echo "Contract details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // Store contract ID for other examples
        if (isset($response['buy']['contract_id'])) {
            $GLOBALS['contract_id'] = $response['buy']['contract_id'];
            echo "Contract ID saved for other examples: " . $GLOBALS['contract_id'] . "\n";
        }
    }
}

function sellContractExample(Trading $trading): void
{
    echo "\n=== Sell Contract Example ===\n";
    
    if (!isset($GLOBALS['contract_id'])) {
        echo "No contract ID available. Please run buyContractExample first.\n";
        return;
    }
    
    $contractId = $GLOBALS['contract_id'];
    $response = $trading->sellContract($contractId);
    
    if (isset($response['error'])) {
        echo "Failed to sell contract: " . $response['error']['message'] . "\n";
    } else {
        echo "Contract sold successfully\n";
        echo "Sell details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getContractInfoExample(Trading $trading): void
{
    echo "\n=== Get Contract Info Example ===\n";
    
    if (!isset($GLOBALS['contract_id'])) {
        echo "No contract ID available. Please run buyContractExample first.\n";
        return;
    }
    
    $contractId = $GLOBALS['contract_id'];
    $response = $trading->getContractInfo($contractId);
    
    if (isset($response['error'])) {
        echo "Failed to get contract info: " . $response['error']['message'] . "\n";
    } else {
        echo "Contract info retrieved successfully\n";
        echo "Contract info: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribeContractInfoExample(Trading $trading): void
{
    echo "\n=== Subscribe to Contract Updates Example ===\n";
    
    if (!isset($GLOBALS['contract_id'])) {
        echo "No contract ID available. Please run buyContractExample first.\n";
        return;
    }
    
    $contractId = $GLOBALS['contract_id'];
    $response = $trading->subscribeContractInfo($contractId);
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to contract updates: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to contract updates successfully\n";
        echo "Initial update: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // In a real application, you would handle the subscription updates here
        // For this example, we'll just wait for a few seconds to receive some updates
        echo "Waiting for updates (5 seconds)...\n";
        sleep(5);
        
        // Note: In a real application, you would process the updates as they arrive
        echo "Subscription example completed\n";
    }
}

function getPriceProposalExample(Trading $trading): void
{
    echo "\n=== Get Price Proposal Example ===\n";
    // Example contract parameters for a price proposal
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $response = $trading->getPriceProposal($contractParams);
    
    if (isset($response['error'])) {
        echo "Failed to get price proposal: " . $response['error']['message'] . "\n";
    } else {
        echo "Price proposal retrieved successfully\n";
        echo "Proposal details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribePriceProposalExample(Trading $trading): void
{
    echo "\n=== Subscribe to Price Proposal Updates Example ===\n";
    // Example contract parameters for a price proposal subscription
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $response = $trading->subscribePriceProposal($contractParams);
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to price proposal updates: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to price proposal updates successfully\n";
        echo "Initial proposal: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // In a real application, you would handle the subscription updates here
        // For this example, we'll just wait for a few seconds to receive some updates
        echo "Waiting for updates (5 seconds)...\n";
        sleep(5);
        
        // Note: In a real application, you would process the updates as they arrive
        echo "Subscription example completed\n";
    }
}

function getPriceForPayoutExample(Trading $trading): void
{
    echo "\n=== Get Price for Payout Example ===\n";
    // Example parameters for price calculation
    $params = [
        'proposal' => 1,
        'amount' => 100,
        'basis' => 'payout',
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'duration' => 60,
        'duration_unit' => 's',
        'symbol' => 'R_100'
    ];
    
    $response = $trading->getPriceForPayout($params);
    
    if (isset($response['error'])) {
        echo "Failed to get price for payout: " . $response['error']['message'] . "\n";
    } else {
        echo "Price for payout retrieved successfully\n";
        echo "Price details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getPortfolioExample(Trading $trading): void
{
    echo "\n=== Get Portfolio Example ===\n";
    $response = $trading->getPortfolio();
    
    if (isset($response['error'])) {
        echo "Failed to get portfolio: " . $response['error']['message'] . "\n";
    } else {
        echo "Portfolio retrieved successfully\n";
        echo "Portfolio details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getProfitTableExample(Trading $trading): void
{
    echo "\n=== Get Profit Table Example ===\n";
    // Example parameters for filtering profit table
    $params = [
        'limit' => 10,
        'offset' => 0,
        'sort' => 'DESC'
    ];
    
    $response = $trading->getProfitTable($params);
    
    if (isset($response['error'])) {
        echo "Failed to get profit table: " . $response['error']['message'] . "\n";
    } else {
        echo "Profit table retrieved successfully\n";
        echo "Profit table details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}