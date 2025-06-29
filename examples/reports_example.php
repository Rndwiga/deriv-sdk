<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Reports;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runStatement = true;
$runProfitTable = true;
$runTransactionDetails = false; // Requires valid contract ID
$runFinancialAssessment = false; // Requires authentication
$runSetFinancialAssessment = false; // Requires authentication
$runTradingDurations = true;
$runAccountStatus = false; // Requires authentication
$runPortfolio = false; // Requires authentication
$runTransactions = false; // Requires authentication
$runOpenPositions = false; // Requires authentication
$runLimitsAndSelfExclusion = false; // Requires authentication

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new Reports instance
    $reports = new Reports($client);

    // Basic reports that don't require authentication
    if ($runTradingDurations) {
        getTradingDurations($reports);
    }
    
    if ($runStatement) {
        getStatement($reports);
    }
    
    if ($runProfitTable) {
        getProfitTable($reports);
    }
    
    if ($runTransactionDetails) {
        getTransactionDetails($reports);
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
            if ($runFinancialAssessment) {
                getFinancialAssessment($reports);
            }
            
            if ($runSetFinancialAssessment) {
                setFinancialAssessment($reports);
            }
            
            if ($runAccountStatus) {
                getAccountStatus($reports);
            }
            
            if ($runPortfolio) {
                getPortfolio($reports);
            }
            
            if ($runTransactions) {
                subscribeTransactions($reports);
            }
            
            if ($runOpenPositions) {
                getOpenPositions($reports);
            }
            
            if ($runLimitsAndSelfExclusion) {
                getLimitsAndSelfExclusion($reports);
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

function getStatement(Reports $reports): void
{
    echo "\n=== Get Account Statement ===\n";
    // Example with optional parameters
    $params = [
        'limit' => 5,
        'offset' => 0,
        'date_from' => strtotime('-7 days'),
        'date_to' => time()
    ];
    
    $response = $reports->getStatement($params);
    
    if (isset($response['error'])) {
        echo "Failed to get statement: " . $response['error']['message'] . "\n";
    } else {
        echo "Statement retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getProfitTable(Reports $reports): void
{
    echo "\n=== Get Profit Table ===\n";
    // Example with optional parameters
    $params = [
        'limit' => 5,
        'offset' => 0,
        'date_from' => strtotime('-30 days'),
        'date_to' => time(),
        'sort' => 'DESC'
    ];
    
    $response = $reports->getProfitTable($params);
    
    if (isset($response['error'])) {
        echo "Failed to get profit table: " . $response['error']['message'] . "\n";
    } else {
        echo "Profit table retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getTransactionDetails(Reports $reports): void
{
    echo "\n=== Get Transaction Details ===\n";
    // Replace with a valid contract ID
    $contractId = 'EXAMPLE_CONTRACT_ID';
    
    $response = $reports->getTransactionDetails($contractId);
    
    if (isset($response['error'])) {
        echo "Failed to get transaction details: " . $response['error']['message'] . "\n";
    } else {
        echo "Transaction details retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getFinancialAssessment(Reports $reports): void
{
    echo "\n=== Get Financial Assessment ===\n";
    $response = $reports->getFinancialAssessment();
    
    if (isset($response['error'])) {
        echo "Failed to get financial assessment: " . $response['error']['message'] . "\n";
    } else {
        echo "Financial assessment retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function setFinancialAssessment(Reports $reports): void
{
    echo "\n=== Set Financial Assessment ===\n";
    // Example financial assessment parameters
    $params = [
        'education_level' => 'Secondary',
        'employment_industry' => 'Finance',
        'estimated_worth' => '$100,000 - $250,000',
        'income_source' => 'Salaried Employee',
        'net_income' => '$25,000 - $50,000',
        'occupation' => 'Financial Advisor'
    ];
    
    $response = $reports->setFinancialAssessment($params);
    
    if (isset($response['error'])) {
        echo "Failed to set financial assessment: " . $response['error']['message'] . "\n";
    } else {
        echo "Financial assessment set successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getTradingDurations(Reports $reports): void
{
    echo "\n=== Get Trading Durations ===\n";
    $response = $reports->getTradingDurations();
    
    if (isset($response['error'])) {
        echo "Failed to get trading durations: " . $response['error']['message'] . "\n";
    } else {
        echo "Trading durations retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountStatus(Reports $reports): void
{
    echo "\n=== Get Account Status ===\n";
    $response = $reports->getAccountStatus();
    
    if (isset($response['error'])) {
        echo "Failed to get account status: " . $response['error']['message'] . "\n";
    } else {
        echo "Account status retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getPortfolio(Reports $reports): void
{
    echo "\n=== Get Portfolio ===\n";
    // Example with optional parameters
    $params = [
        'contract_type' => 'CALL',
        'limit' => 5
    ];
    
    $response = $reports->getPortfolio($params);
    
    if (isset($response['error'])) {
        echo "Failed to get portfolio: " . $response['error']['message'] . "\n";
    } else {
        echo "Portfolio retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribeTransactions(Reports $reports): void
{
    echo "\n=== Subscribe to Transactions ===\n";
    $response = $reports->subscribeTransactions();
    
    if (isset($response['error'])) {
        echo "Failed to subscribe to transactions: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to transactions successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getOpenPositions(Reports $reports): void
{
    echo "\n=== Get Open Positions ===\n";
    $response = $reports->getOpenPositions();
    
    if (isset($response['error'])) {
        echo "Failed to get open positions: " . $response['error']['message'] . "\n";
    } else {
        echo "Open positions retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getLimitsAndSelfExclusion(Reports $reports): void
{
    echo "\n=== Get Limits and Self-Exclusion ===\n";
    $response = $reports->getLimitsAndSelfExclusion();
    
    if (isset($response['error'])) {
        echo "Failed to get limits and self-exclusion: " . $response['error']['message'] . "\n";
    } else {
        echo "Limits and self-exclusion retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}