<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runGetAccountInfo = true;
$runGetSettings = true;
$runSetSettings = false; // Requires authentication
$runGetLimits = true;
$runGetBalance = true;
$runGetSelfExclusion = false; // Requires authentication
$runSetSelfExclusion = false; // Requires authentication

// Create a new DerivClient instance
$client = new DerivClient($appId);

try {
    // Create a new Account instance
    $account = new Account($client);

    // Authenticate with the API (if using authenticated endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $account->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";
            
            // Run authenticated examples
            if ($runSetSettings) {
                //updateAccountSettings($account);
            }
            
            if ($runGetSelfExclusion) {
                getSelfExclusionSettings($account);
            }
            
            if ($runSetSelfExclusion) {
                //updateSelfExclusionSettings($account);
            }


            if ($runGetAccountInfo) {
                getAccountInfo($account);
            }

            if ($runGetSettings) {
                getAccountSettings($account);
            }

            if ($runGetLimits) {
                getAccountLimits($account);
            }

            if ($runGetBalance) {
                getAccountBalance($account);
            }

            // Logout if authenticated
            if ($token && $token !== 'YOUR_API_TOKEN') {
                //logoutFromAccount($account);
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

function getAccountInfo(Account $account): void
{
    echo "\n=== Get Account Information ===\n";
    $response = $account->getAccountInfo();
    
    if (isset($response['error'])) {
        echo "Failed to get account information: " . $response['error']['message'] . "\n";
    } else {
        echo "Account information retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountSettings(Account $account): void
{
    echo "\n=== Get Account Settings ===\n";
    $response = $account->getSettings();
    
    if (isset($response['error'])) {
        echo "Failed to get account settings: " . $response['error']['message'] . "\n";
    } else {
        echo "Account settings retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function updateAccountSettings(Account $account): void
{
    echo "\n=== Update Account Settings ===\n";
    // Example settings to update
    $settings = [
        'email_consent' => 1,
        'place_of_birth' => 'us',
        'tax_residence' => 'us'
    ];
    
    $response = $account->setSettings($settings);
    
    if (isset($response['error'])) {
        echo "Failed to update account settings: " . $response['error']['message'] . "\n";
    } else {
        echo "Account settings updated successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountLimits(Account $account): void
{
    echo "\n=== Get Account Limits ===\n";
    $response = $account->getLimits();
    
    if (isset($response['error'])) {
        echo "Failed to get account limits: " . $response['error']['message'] . "\n";
    } else {
        echo "Account limits retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountBalance(Account $account): void
{
    echo "\n=== Get Account Balance ===\n";
    // Get balance without specifying account type
    $response = $account->getBalance();
    
    if (isset($response['error'])) {
        echo "Failed to get account balance: " . $response['error']['message'] . "\n";
    } else {
        echo "Account balance retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
    
    // Example with specific account type
    echo "\n=== Get Specific Account Balance ===\n";
    $response = $account->getBalance('current'); //You can pass the account number
    
    if (isset($response['error'])) {
        echo "Failed to get specific account balance: " . $response['error']['message'] . "\n";
    } else {
        echo "Specific account balance retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getSelfExclusionSettings(Account $account): void
{
    echo "\n=== Get Self-Exclusion Settings ===\n";
    $response = $account->getSelfExclusion();
    
    if (isset($response['error'])) {
        echo "Failed to get self-exclusion settings: " . $response['error']['message'] . "\n";
    } else {
        echo "Self-exclusion settings retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function updateSelfExclusionSettings(Account $account): void
{
    echo "\n=== Update Self-Exclusion Settings ===\n";
    // Example self-exclusion parameters
    $params = [
        'max_losses' => 1000,
        'max_turnover' => 5000,
        'max_open_bets' => 10
    ];
    
    $response = $account->setSelfExclusion($params);
    
    if (isset($response['error'])) {
        echo "Failed to update self-exclusion settings: " . $response['error']['message'] . "\n";
    } else {
        echo "Self-exclusion settings updated successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function logoutFromAccount(Account $account): void
{
    echo "\n=== Logout ===\n";
    $response = $account->logout();
    
    if (isset($response['error'])) {
        echo "Failed to logout: " . $response['error']['message'] . "\n";
    } else {
        echo "Logged out successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}