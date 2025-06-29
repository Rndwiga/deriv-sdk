<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Cashier;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runCashierInfo = true;
$runDepositInfo = true;
$runWithdrawalInfo = true;
$runTransferBetweenAccounts = false; // Requires authentication
$runAccountTransferHistory = false; // Requires authentication
$runCryptoCurrenciesConfig = true;
$runPaymentMethods = true;

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new Cashier instance
    $cashier = new Cashier($client);

    // Basic cashier operations that don't require authentication
    if ($runCashierInfo) {
        getCashierInfo($cashier);
    }
    
    if ($runDepositInfo) {
        getDepositInfo($cashier);
    }
    
    if ($runWithdrawalInfo) {
        getWithdrawalInfo($cashier);
    }
    
    if ($runCryptoCurrenciesConfig) {
        getCryptoCurrenciesConfig($cashier);
    }
    
    if ($runPaymentMethods) {
        getPaymentMethods($cashier);
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
            if ($runTransferBetweenAccounts) {
                transferBetweenAccounts($cashier);
            }
            
            if ($runAccountTransferHistory) {
                getAccountTransferHistory($cashier);
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

function getCashierInfo(Cashier $cashier): void
{
    echo "\n=== Get Cashier Info ===\n";
    $response = $cashier->getCashierInfo();
    
    if (isset($response['error'])) {
        echo "Failed to get cashier info: " . $response['error']['message'] . "\n";
    } else {
        echo "Cashier info retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getDepositInfo(Cashier $cashier): void
{
    echo "\n=== Get Deposit Info ===\n";
    $response = $cashier->getDepositInfo();
    
    if (isset($response['error'])) {
        echo "Failed to get deposit info: " . $response['error']['message'] . "\n";
    } else {
        echo "Deposit info retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getWithdrawalInfo(Cashier $cashier): void
{
    echo "\n=== Get Withdrawal Info ===\n";
    $response = $cashier->getWithdrawalInfo();
    
    if (isset($response['error'])) {
        echo "Failed to get withdrawal info: " . $response['error']['message'] . "\n";
    } else {
        echo "Withdrawal info retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function transferBetweenAccounts(Cashier $cashier): void
{
    echo "\n=== Transfer Between Accounts ===\n";
    
    // Example parameters for transferring funds
    $transferParams = [
        'account_from' => 'CR123456',  // Replace with actual account ID
        'account_to' => 'CR654321',    // Replace with actual account ID
        'amount' => 100.00,            // Amount to transfer
        'currency' => 'USD'            // Currency of the transfer
    ];
    
    $response = $cashier->transferBetweenAccounts($transferParams);
    
    if (isset($response['error'])) {
        echo "Failed to transfer funds: " . $response['error']['message'] . "\n";
    } else {
        echo "Funds transferred successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountTransferHistory(Cashier $cashier): void
{
    echo "\n=== Get Account Transfer History ===\n";
    
    // Optional parameters for filtering the history
    $historyParams = [
        'limit' => 10,                 // Limit the number of records returned
        'offset' => 0,                 // Starting offset
        // 'date_from' => '2023-01-01',  // Optional start date
        // 'date_to' => '2023-12-31'     // Optional end date
    ];
    
    $response = $cashier->getAccountTransferHistory($historyParams);
    
    if (isset($response['error'])) {
        echo "Failed to get transfer history: " . $response['error']['message'] . "\n";
    } else {
        echo "Transfer history retrieved successfully\n";
        echo "Total transfers: " . (isset($response['account_transfer_history']) ? count($response['account_transfer_history']) : 0) . "\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getCryptoCurrenciesConfig(Cashier $cashier): void
{
    echo "\n=== Get Crypto Currencies Config ===\n";
    $response = $cashier->getCryptoCurrenciesConfig();
    
    if (isset($response['error'])) {
        echo "Failed to get crypto currencies config: " . $response['error']['message'] . "\n";
    } else {
        echo "Crypto currencies config retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getPaymentMethods(Cashier $cashier): void
{
    echo "\n=== Get Payment Methods ===\n";
    
    // Example country code
    $countryCode = 'us';
    
    $response = $cashier->getPaymentMethods($countryCode);
    
    if (isset($response['error'])) {
        echo "Failed to get payment methods: " . $response['error']['message'] . "\n";
    } else {
        echo "Payment methods retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}