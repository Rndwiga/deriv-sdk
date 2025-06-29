<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\Utilities;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runExchangeRates = true;
$runCountriesList = true;
$runStatesList = true;
$runVerifyEmail = false; // Requires valid email
$runAppOperations = false; // Requires valid app credentials
$runApiTokenOperations = false; // Requires authentication

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new Utilities instance
    $utilities = new Utilities($client);

    // Basic utilities that don't require authentication
    pingServer($utilities);
    getServerTime($utilities);
    getWebsiteStatus($utilities);
    
    if ($runExchangeRates) {
        getExchangeRates($utilities);
    }
    
    if ($runCountriesList) {
        getCountriesList($utilities);
    }
    
    if ($runStatesList) {
        getStatesList($utilities);
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
            if ($runVerifyEmail) {
                verifyEmail($utilities);
            }
            
            if ($runAppOperations) {
                manageApps($utilities);
            }
            
            if ($runApiTokenOperations) {
                manageApiTokens($utilities);
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

function pingServer(Utilities $utilities): void
{
    echo "\n=== Ping Server ===\n";
    $response = $utilities->ping();
    
    if (isset($response['error'])) {
        echo "Failed to ping server: " . $response['error']['message'] . "\n";
    } else {
        echo "Server pinged successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getServerTime(Utilities $utilities): void
{
    echo "\n=== Get Server Time ===\n";
    $response = $utilities->getServerTime();
    
    if (isset($response['error'])) {
        echo "Failed to get server time: " . $response['error']['message'] . "\n";
    } else {
        echo "Server time retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getWebsiteStatus(Utilities $utilities): void
{
    echo "\n=== Get Website Status ===\n";
    $response = $utilities->getWebsiteStatus();
    
    if (isset($response['error'])) {
        echo "Failed to get website status: " . $response['error']['message'] . "\n";
    } else {
        echo "Website status retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getExchangeRates(Utilities $utilities): void
{
    echo "\n=== Get Exchange Rates ===\n";
    // Example with base currency USD and specific target currencies
    $response = $utilities->getExchangeRates('USD', ['EUR', 'GBP', 'AUD']);
    
    if (isset($response['error'])) {
        echo "Failed to get exchange rates: " . $response['error']['message'] . "\n";
    } else {
        echo "Exchange rates retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function getCountriesList(Utilities $utilities): void
{
    echo "\n=== Get Countries List ===\n";
    $response = $utilities->getCountriesList();
    
    if (isset($response['error'])) {
        echo "Failed to get countries list: " . $response['error']['message'] . "\n";
    } else {
        echo "Countries list retrieved successfully\n";
        echo "Total countries: " . (isset($response['residence_list']) ? count($response['residence_list']) : 0) . "\n";
        // Don't print the full list as it would be too long
        echo "First few countries: " . json_encode(array_slice($response['residence_list'] ?? [], 0, 3), JSON_PRETTY_PRINT) . "\n";
    }
}

function getStatesList(Utilities $utilities): void
{
    echo "\n=== Get States List ===\n";
    // Example with US states
    $response = $utilities->getStatesList('us');
    
    if (isset($response['error'])) {
        echo "Failed to get states list: " . $response['error']['message'] . "\n";
    } else {
        echo "States list retrieved successfully\n";
        echo "Total states: " . (isset($response['states_list']) ? count($response['states_list']) : 0) . "\n";
        // Don't print the full list as it would be too long
        echo "First few states: " . json_encode(array_slice($response['states_list'] ?? [], 0, 3), JSON_PRETTY_PRINT) . "\n";
    }
}

function verifyEmail(Utilities $utilities): void
{
    echo "\n=== Verify Email ===\n";
    // Replace with a valid email and verification type
    $email = 'example@example.com';
    $type = 'account_opening';
    
    $response = $utilities->verifyEmail($email, $type);
    
    if (isset($response['error'])) {
        echo "Failed to verify email: " . $response['error']['message'] . "\n";
    } else {
        echo "Email verification initiated successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function manageApps(Utilities $utilities): void
{
    echo "\n=== App Management ===\n";
    
    // List all apps
    echo "Listing all apps...\n";
    $listResponse = $utilities->listApps();
    
    if (isset($listResponse['error'])) {
        echo "Failed to list apps: " . $listResponse['error']['message'] . "\n";
    } else {
        echo "Apps listed successfully\n";
        echo "Total apps: " . (isset($listResponse['app_list']) ? count($listResponse['app_list']) : 0) . "\n";
        
        // Register a new app
        echo "\nRegistering a new app...\n";
        $registerParams = [
            'name' => 'Test App',
            'scopes' => ['read', 'trade'],
            'redirect_uri' => 'https://example.com/callback'
        ];
        
        $registerResponse = $utilities->registerApp($registerParams);
        
        if (isset($registerResponse['error'])) {
            echo "Failed to register app: " . $registerResponse['error']['message'] . "\n";
        } else {
            echo "App registered successfully\n";
            echo "App details: " . json_encode($registerResponse, JSON_PRETTY_PRINT) . "\n";
            
            // Get app info
            if (isset($registerResponse['app_register']['app_id'])) {
                $appId = $registerResponse['app_register']['app_id'];
                
                echo "\nGetting app info for app ID: $appId\n";
                $infoResponse = $utilities->getAppInfo($appId);
                
                if (isset($infoResponse['error'])) {
                    echo "Failed to get app info: " . $infoResponse['error']['message'] . "\n";
                } else {
                    echo "App info retrieved successfully\n";
                    echo "App info: " . json_encode($infoResponse, JSON_PRETTY_PRINT) . "\n";
                }
                
                // Update app
                echo "\nUpdating app...\n";
                $updateParams = [
                    'name' => 'Updated Test App',
                    'scopes' => ['read', 'trade', 'payments']
                ];
                
                $updateResponse = $utilities->updateApp($appId, $updateParams);
                
                if (isset($updateResponse['error'])) {
                    echo "Failed to update app: " . $updateResponse['error']['message'] . "\n";
                } else {
                    echo "App updated successfully\n";
                    echo "Updated app details: " . json_encode($updateResponse, JSON_PRETTY_PRINT) . "\n";
                }
                
                // Delete app
                echo "\nDeleting app...\n";
                $deleteResponse = $utilities->deleteApp($appId);
                
                if (isset($deleteResponse['error'])) {
                    echo "Failed to delete app: " . $deleteResponse['error']['message'] . "\n";
                } else {
                    echo "App deleted successfully\n";
                    echo "Delete response: " . json_encode($deleteResponse, JSON_PRETTY_PRINT) . "\n";
                }
            }
        }
    }
}

function manageApiTokens(Utilities $utilities): void
{
    echo "\n=== API Token Management ===\n";
    
    // Get API token scopes
    echo "Getting API token scopes...\n";
    $scopesResponse = $utilities->getApiTokenScopes();
    
    if (isset($scopesResponse['error'])) {
        echo "Failed to get API token scopes: " . $scopesResponse['error']['message'] . "\n";
    } else {
        echo "API token scopes retrieved successfully\n";
        echo "Scopes: " . json_encode($scopesResponse, JSON_PRETTY_PRINT) . "\n";
        
        // Create API token
        echo "\nCreating API token...\n";
        $createParams = [
            'name' => 'Test Token',
            'scopes' => ['read', 'trade']
        ];
        
        $createResponse = $utilities->createApiToken($createParams);
        
        if (isset($createResponse['error'])) {
            echo "Failed to create API token: " . $createResponse['error']['message'] . "\n";
        } else {
            echo "API token created successfully\n";
            echo "Token details: " . json_encode($createResponse, JSON_PRETTY_PRINT) . "\n";
            
            // Delete API token
            if (isset($createResponse['api_token']['token'])) {
                $token = $createResponse['api_token']['token'];
                
                echo "\nDeleting API token...\n";
                $deleteResponse = $utilities->deleteApiToken($token);
                
                if (isset($deleteResponse['error'])) {
                    echo "Failed to delete API token: " . $deleteResponse['error']['message'] . "\n";
                } else {
                    echo "API token deleted successfully\n";
                    echo "Delete response: " . json_encode($deleteResponse, JSON_PRETTY_PRINT) . "\n";
                }
            }
        }
    }
}