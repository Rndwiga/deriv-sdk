<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\MT5;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runAccountDetails = true;
$runAccountTypes = true;
$runAccountBalance = true;
$runTransactionHistory = true;
$runTradeHistory = true;
$runOpenPositions = true;

// These operations modify data and should be used with caution
$runCreateAccount = false;
$runDepositWithdraw = false;
$runPasswordOperations = false;
$runAccountSettings = false;
$runOrderOperations = false;

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new MT5 instance
    $mt5 = new MT5($client);

    // Authenticate with the API (required for MT5 operations)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Basic MT5 account information
            if ($runAccountDetails) {
                getAccountDetails($mt5);
            }
            
            if ($runAccountTypes) {
                getAccountTypes($mt5);
            }
            
            if ($runAccountBalance) {
                getAccountBalance($mt5);
            }
            
            if ($runTransactionHistory) {
                getTransactionHistory($mt5);
            }
            
            if ($runTradeHistory) {
                getTradeHistory($mt5);
            }
            
            if ($runOpenPositions) {
                getOpenPositions($mt5);
            }

            // Operations that modify data
            if ($runCreateAccount) {
                createAccount($mt5);
            }
            
            if ($runDepositWithdraw) {
                depositAndWithdraw($mt5);
            }
            
            if ($runPasswordOperations) {
                passwordOperations($mt5);
            }
            
            if ($runAccountSettings) {
                updateAccountSettings($mt5);
            }
            
            if ($runOrderOperations) {
                orderOperations($mt5);
            }
        }
    } else {
        echo "API token is required for MT5 operations. Please provide a valid token.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getAccountDetails(MT5 $mt5): void
{
    echo "\n=== Get MT5 Account Details ===\n";
    
    // Get all MT5 accounts
    $response = $mt5->getAccountDetails();
    
    if (isset($response['error'])) {
        echo "Failed to get MT5 account details: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 account details retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // If we have accounts, get details for the first one
        if (isset($response['mt5_login_list']) && !empty($response['mt5_login_list'])) {
            $firstAccount = $response['mt5_login_list'][0];
            $loginId = $firstAccount['login'];
            
            echo "\nGetting details for specific MT5 account (login: $loginId)...\n";
            $specificResponse = $mt5->getAccountDetails($loginId);
            
            if (isset($specificResponse['error'])) {
                echo "Failed to get specific MT5 account details: " . $specificResponse['error']['message'] . "\n";
            } else {
                echo "Specific MT5 account details retrieved successfully\n";
                echo "Response: " . json_encode($specificResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
    }
}

function getAccountTypes(MT5 $mt5): void
{
    echo "\n=== Get MT5 Account Types ===\n";
    $response = $mt5->getAccountTypes();
    
    if (isset($response['error'])) {
        echo "Failed to get MT5 account types: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 account types retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getAccountBalance(MT5 $mt5): void
{
    echo "\n=== Get MT5 Account Balance ===\n";
    
    // First, get the list of accounts to find a login ID
    $accountsResponse = $mt5->getAccountDetails();
    
    if (isset($accountsResponse['error'])) {
        echo "Failed to get MT5 accounts: " . $accountsResponse['error']['message'] . "\n";
    } else if (isset($accountsResponse['mt5_login_list']) && !empty($accountsResponse['mt5_login_list'])) {
        $firstAccount = $accountsResponse['mt5_login_list'][0];
        $loginId = $firstAccount['login'];
        
        echo "Getting balance for MT5 account (login: $loginId)...\n";
        $balanceResponse = $mt5->getAccountBalance($loginId);
        
        if (isset($balanceResponse['error'])) {
            echo "Failed to get MT5 account balance: " . $balanceResponse['error']['message'] . "\n";
        } else {
            echo "MT5 account balance retrieved successfully\n";
            echo "Response: " . json_encode($balanceResponse, JSON_PRETTY_PRINT) . "\n";
        }
    } else {
        echo "No MT5 accounts found to check balance\n";
    }
}

function getTransactionHistory(MT5 $mt5): void
{
    echo "\n=== Get MT5 Transaction History ===\n";
    
    // Example with optional parameters
    $params = [
        'limit' => 10,
        'offset' => 0,
        // Add date filters if needed
        // 'from' => '2023-01-01',
        // 'to' => '2023-12-31'
    ];
    
    $response = $mt5->getTransactionHistory($params);
    
    if (isset($response['error'])) {
        echo "Failed to get MT5 transaction history: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 transaction history retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getTradeHistory(MT5 $mt5): void
{
    echo "\n=== Get MT5 Trade History ===\n";
    
    // Example with optional parameters
    $params = [
        'limit' => 10,
        'offset' => 0,
        // Add other filters if needed
        // 'login' => '12345',
        // 'from' => '2023-01-01',
        // 'to' => '2023-12-31'
    ];
    
    $response = $mt5->getMT5TradeHistory($params);
    
    if (isset($response['error'])) {
        echo "Failed to get MT5 trade history: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 trade history retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getOpenPositions(MT5 $mt5): void
{
    echo "\n=== Get MT5 Open Positions ===\n";
    
    // Example with optional parameters
    $params = [
        'limit' => 10,
        'offset' => 0,
        // Add login filter if needed
        // 'login' => '12345'
    ];
    
    $response = $mt5->getMT5OpenPositions($params);
    
    if (isset($response['error'])) {
        echo "Failed to get MT5 open positions: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 open positions retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function createAccount(MT5 $mt5): void
{
    echo "\n=== Create MT5 Account ===\n";
    
    // Example parameters for creating a real MT5 account
    $params = [
        'account_type' => 'real',
        'address' => '123 Main St',
        'city' => 'New York',
        'company' => 'Deriv',
        'country' => 'us',
        'email' => 'example@example.com',
        'leverage' => 100,
        'mainPassword' => 'SecurePass123!',
        'mt5_account_category' => 'standard',
        'mt5_account_type' => 'financial',
        'name' => 'John Doe',
        'phone' => '+1234567890',
        'state' => 'NY',
        'zipCode' => '10001'
    ];
    
    $response = $mt5->createAccount($params);
    
    if (isset($response['error'])) {
        echo "Failed to create MT5 account: " . $response['error']['message'] . "\n";
    } else {
        echo "MT5 account created successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function depositAndWithdraw(MT5 $mt5): void
{
    echo "\n=== MT5 Deposit and Withdrawal ===\n";
    
    // First, get the list of accounts to find a login ID
    $accountsResponse = $mt5->getAccountDetails();
    
    if (isset($accountsResponse['error'])) {
        echo "Failed to get MT5 accounts: " . $accountsResponse['error']['message'] . "\n";
    } else if (isset($accountsResponse['mt5_login_list']) && !empty($accountsResponse['mt5_login_list'])) {
        $firstAccount = $accountsResponse['mt5_login_list'][0];
        $loginId = $firstAccount['login'];
        
        // Deposit example
        echo "Depositing to MT5 account (login: $loginId)...\n";
        $amount = 100.00; // Example amount
        $depositResponse = $mt5->deposit($loginId, $amount);
        
        if (isset($depositResponse['error'])) {
            echo "Failed to deposit to MT5 account: " . $depositResponse['error']['message'] . "\n";
        } else {
            echo "Deposit to MT5 account successful\n";
            echo "Deposit response: " . json_encode($depositResponse, JSON_PRETTY_PRINT) . "\n";
            
            // Withdraw example (only if deposit was successful)
            echo "\nWithdrawing from MT5 account (login: $loginId)...\n";
            $withdrawResponse = $mt5->withdraw($loginId, $amount);
            
            if (isset($withdrawResponse['error'])) {
                echo "Failed to withdraw from MT5 account: " . $withdrawResponse['error']['message'] . "\n";
            } else {
                echo "Withdrawal from MT5 account successful\n";
                echo "Withdrawal response: " . json_encode($withdrawResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
    } else {
        echo "No MT5 accounts found for deposit/withdrawal operations\n";
    }
}

function passwordOperations(MT5 $mt5): void
{
    echo "\n=== MT5 Password Operations ===\n";
    
    // First, get the list of accounts to find a login ID
    $accountsResponse = $mt5->getAccountDetails();
    
    if (isset($accountsResponse['error'])) {
        echo "Failed to get MT5 accounts: " . $accountsResponse['error']['message'] . "\n";
    } else if (isset($accountsResponse['mt5_login_list']) && !empty($accountsResponse['mt5_login_list'])) {
        $firstAccount = $accountsResponse['mt5_login_list'][0];
        $loginId = $firstAccount['login'];
        
        // Password reset example
        echo "Requesting password reset for MT5 account (login: $loginId)...\n";
        $passwordType = 'main'; // 'main' or 'investor'
        $resetResponse = $mt5->passwordReset($loginId, $passwordType);
        
        if (isset($resetResponse['error'])) {
            echo "Failed to request password reset: " . $resetResponse['error']['message'] . "\n";
        } else {
            echo "Password reset request successful\n";
            echo "Reset response: " . json_encode($resetResponse, JSON_PRETTY_PRINT) . "\n";
            
            // Password change example
            echo "\nChanging password for MT5 account (login: $loginId)...\n";
            $oldPassword = 'OldPassword123!';
            $newPassword = 'NewPassword456!';
            $changeResponse = $mt5->passwordChange($loginId, $passwordType, $oldPassword, $newPassword);
            
            if (isset($changeResponse['error'])) {
                echo "Failed to change password: " . $changeResponse['error']['message'] . "\n";
            } else {
                echo "Password change successful\n";
                echo "Change response: " . json_encode($changeResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
    } else {
        echo "No MT5 accounts found for password operations\n";
    }
}

function updateAccountSettings(MT5 $mt5): void
{
    echo "\n=== Update MT5 Account Settings ===\n";
    
    // First, get the list of accounts to find a login ID
    $accountsResponse = $mt5->getAccountDetails();
    
    if (isset($accountsResponse['error'])) {
        echo "Failed to get MT5 accounts: " . $accountsResponse['error']['message'] . "\n";
    } else if (isset($accountsResponse['mt5_login_list']) && !empty($accountsResponse['mt5_login_list'])) {
        $firstAccount = $accountsResponse['mt5_login_list'][0];
        $loginId = $firstAccount['login'];
        
        // Example settings to update
        $settings = [
            'leverage' => 200,
            'name' => 'Updated Name'
        ];
        
        echo "Updating settings for MT5 account (login: $loginId)...\n";
        $response = $mt5->setAccountSettings($loginId, $settings);
        
        if (isset($response['error'])) {
            echo "Failed to update MT5 account settings: " . $response['error']['message'] . "\n";
        } else {
            echo "MT5 account settings updated successfully\n";
            echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        }
    } else {
        echo "No MT5 accounts found to update settings\n";
    }
}

function orderOperations(MT5 $mt5): void
{
    echo "\n=== MT5 Order Operations ===\n";
    
    // First, get the list of accounts to find a login ID
    $accountsResponse = $mt5->getAccountDetails();
    
    if (isset($accountsResponse['error'])) {
        echo "Failed to get MT5 accounts: " . $accountsResponse['error']['message'] . "\n";
    } else if (isset($accountsResponse['mt5_login_list']) && !empty($accountsResponse['mt5_login_list'])) {
        $firstAccount = $accountsResponse['mt5_login_list'][0];
        $loginId = $firstAccount['login'];
        
        // Place order example
        echo "Placing order for MT5 account (login: $loginId)...\n";
        $orderParams = [
            'login' => $loginId,
            'symbol' => 'EURUSD',
            'type' => 'ORDER_TYPE_BUY',
            'volume' => 0.1,
            'price' => 1.1000
        ];
        
        $placeResponse = $mt5->placeMT5Order($orderParams);
        
        if (isset($placeResponse['error'])) {
            echo "Failed to place MT5 order: " . $placeResponse['error']['message'] . "\n";
        } else {
            echo "MT5 order placed successfully\n";
            echo "Place order response: " . json_encode($placeResponse, JSON_PRETTY_PRINT) . "\n";
            
            // If order was placed successfully, try to modify it
            if (isset($placeResponse['mt5_place_order']) && isset($placeResponse['mt5_place_order']['order_id'])) {
                $orderId = $placeResponse['mt5_place_order']['order_id'];
                
                echo "\nModifying MT5 order (ID: $orderId)...\n";
                $modifyParams = [
                    'price' => 1.1050,
                    'volume' => 0.2
                ];
                
                $modifyResponse = $mt5->modifyMT5Order($orderId, $modifyParams);
                
                if (isset($modifyResponse['error'])) {
                    echo "Failed to modify MT5 order: " . $modifyResponse['error']['message'] . "\n";
                } else {
                    echo "MT5 order modified successfully\n";
                    echo "Modify order response: " . json_encode($modifyResponse, JSON_PRETTY_PRINT) . "\n";
                }
                
                // Get open positions to find a position to close
                $positionsResponse = $mt5->getMT5OpenPositions(['login' => $loginId]);
                
                if (isset($positionsResponse['error'])) {
                    echo "Failed to get MT5 open positions: " . $positionsResponse['error']['message'] . "\n";
                } else if (isset($positionsResponse['mt5_open_positions']) && !empty($positionsResponse['mt5_open_positions'])) {
                    $firstPosition = $positionsResponse['mt5_open_positions'][0];
                    $positionId = $firstPosition['position_id'];
                    
                    echo "\nClosing MT5 position (ID: $positionId)...\n";
                    $closeResponse = $mt5->closeMT5Position($positionId);
                    
                    if (isset($closeResponse['error'])) {
                        echo "Failed to close MT5 position: " . $closeResponse['error']['message'] . "\n";
                    } else {
                        echo "MT5 position closed successfully\n";
                        echo "Close position response: " . json_encode($closeResponse, JSON_PRETTY_PRINT) . "\n";
                    }
                } else {
                    echo "No open positions found to close\n";
                }
            }
        }
    } else {
        echo "No MT5 accounts found for order operations\n";
    }
}