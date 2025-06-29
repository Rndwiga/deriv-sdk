<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Wallet;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runGetWalletAccounts = true;
$runCreateWalletAccount = false; // Requires authentication
$runGetWalletTransactions = false; // Requires authentication and a valid wallet ID
$runTransferBetweenWallets = false; // Requires authentication and valid wallet IDs

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new Wallet instance
    $wallet = new Wallet($client);

    // Authenticate with the API (if using authenticated endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Examples that require authentication
            if ($runGetWalletAccounts) {
                getWalletAccounts($wallet);
            }
            
            if ($runCreateWalletAccount) {
                createWalletAccount($wallet);
            }
            
            if ($runGetWalletTransactions) {
                getWalletTransactions($wallet);
            }
            
            if ($runTransferBetweenWallets) {
                transferBetweenWallets($wallet);
            }
        }
    } else {
        // For unauthenticated examples
        if ($runGetWalletAccounts) {
            getWalletAccounts($wallet);
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getWalletAccounts(Wallet $wallet): void
{
    echo "\n=== Get Wallet Accounts ===\n";
    $response = $wallet->getWalletAccounts();
    
    if (isset($response['error'])) {
        echo "Failed to get wallet accounts: " . $response['error']['message'] . "\n";
    } else {
        echo "Wallet accounts retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function createWalletAccount(Wallet $wallet): void
{
    echo "\n=== Create Wallet Account ===\n";
    // Example parameters for creating a wallet account
    $params = [
        'currency' => 'USD',
        'name' => 'My USD Wallet'
    ];
    
    $response = $wallet->createWalletAccount($params);
    
    if (isset($response['error'])) {
        echo "Failed to create wallet account: " . $response['error']['message'] . "\n";
    } else {
        echo "Wallet account created successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getWalletTransactions(Wallet $wallet): void
{
    echo "\n=== Get Wallet Transactions ===\n";
    // Replace with a valid wallet ID
    $walletId = 'YOUR_WALLET_ID';
    
    // Optional parameters for filtering transactions
    $params = [
        'limit' => 10,
        'offset' => 0
    ];
    
    $response = $wallet->getWalletTransactions($walletId, $params);
    
    if (isset($response['error'])) {
        echo "Failed to get wallet transactions: " . $response['error']['message'] . "\n";
    } else {
        echo "Wallet transactions retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function transferBetweenWallets(Wallet $wallet): void
{
    echo "\n=== Transfer Between Wallets ===\n";
    // Example parameters for transferring between wallets
    $params = [
        'from_wallet' => 'SOURCE_WALLET_ID',
        'to_wallet' => 'DESTINATION_WALLET_ID',
        'amount' => 100.00,
        'currency' => 'USD'
    ];
    
    $response = $wallet->transferBetweenWallets($params);
    
    if (isset($response['error'])) {
        echo "Failed to transfer between wallets: " . $response['error']['message'] . "\n";
    } else {
        echo "Transfer between wallets completed successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}