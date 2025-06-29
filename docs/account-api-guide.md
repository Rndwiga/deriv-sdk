# Account API Guide

This guide provides comprehensive documentation on how to use the `Account` class from the Deriv APIs package. The `Account` class provides methods for interacting with Deriv's account-related APIs.

## Table of Contents

- [Installation](#installation)
- [Getting Started](#getting-started)
- [Available Methods](#available-methods)
  - [Authentication](#authentication)
  - [Account Information](#account-information)
  - [Account Settings](#account-settings)
  - [Account Limits](#account-limits)
  - [Account Balance](#account-balance)
  - [Self-Exclusion](#self-exclusion)
- [Error Handling](#error-handling)
- [Examples](#examples)

## Installation

First, ensure you have the package installed:

```bash
composer require rndwiga/deriv-apis
```

## Getting Started

To use the `Account` class, you first need to create an instance of the `DerivClient` and then pass it to the `Account` constructor:

```php
use Rndwiga\DerivApis\Client\DerivClient;
use Rndwiga\DerivApis\Api\Account;

// Create a new DerivClient instance
$client = new DerivClient('your-app-id');

// Create a new Account instance
$account = new Account($client);
```

## Available Methods

### Authentication

#### Authorize

Authenticate with the Deriv API using an API token:

```php
$response = $account->authorize('your-api-token');
```

Example response:
```php
[
    'authorize' => [
        'email' => 'example@email.com',
        'currency' => 'USD',
        'balance' => 1000.00,
        'loginid' => 'CR123456',
        // ... other account details
    ]
]
```

#### Logout

Log out from the current session:

```php
$response = $account->logout();
```

Example response:
```php
[
    'logout' => 1
]
```

### Account Information

#### Get Account Information

Retrieve information about the account status:

```php
$response = $account->getAccountInfo();
```

Example response:
```php
[
    'get_account_status' => [
        'status' => [
            'authentication' => [
                'identity' => [
                    'status' => 'none'
                ],
                'document' => [
                    'status' => 'none'
                ],
                // ... other authentication details
            ],
            'currency_config' => [
                // ... currency configuration details
            ]
        ]
    ]
]
```

### Account Settings

#### Get Settings

Retrieve the account settings:

```php
$response = $account->getSettings();
```

Example response:
```php
[
    'get_settings' => [
        'email' => 'example@email.com',
        'address_line_1' => '123 Main St',
        'address_line_2' => 'Apt 4B',
        'address_city' => 'New York',
        'address_state' => 'NY',
        'address_postcode' => '10001',
        'country' => 'us',
        'phone' => '+1234567890',
        // ... other settings
    ]
]
```

#### Set Settings

Update the account settings:

```php
$settings = [
    'address_line_1' => '456 New St',
    'address_city' => 'Los Angeles',
    'address_state' => 'CA',
    'address_postcode' => '90001',
    'phone' => '+1987654321'
];

$response = $account->setSettings($settings);
```

Example response:
```php
[
    'set_settings' => 1
]
```

### Account Limits

#### Get Limits

Retrieve the account limits:

```php
$response = $account->getLimits();
```

Example response:
```php
[
    'get_limits' => [
        'withdrawal_limit' => 1000.00,
        'withdrawal_limit_remaining' => 1000.00,
        'open_positions' => 0,
        'account_balance' => 1000.00,
        'daily_turnover' => 0,
        'payout_limit' => 50000.00,
        // ... other limits
    ]
]
```

### Account Balance

#### Get Balance

Retrieve the account balance:

```php
// Get balance for the default account
$response = $account->getBalance();

// Get balance for a specific account
$response = $account->getBalance('CR123456');
```

Example response:
```php
[
    'balance' => [
        'balance' => 1000.00,
        'currency' => 'USD',
        'loginid' => 'CR123456'
    ]
]
```

### Self-Exclusion

#### Get Self-Exclusion

Retrieve the self-exclusion settings:

```php
$response = $account->getSelfExclusion();
```

Example response:
```php
[
    'get_self_exclusion' => [
        'max_balance' => 100000,
        'max_turnover' => 5000,
        'max_losses' => 1000,
        'max_7day_turnover' => 10000,
        'max_7day_losses' => 5000,
        'max_30day_turnover' => 30000,
        'max_30day_losses' => 10000,
        'session_duration_limit' => 3600,
        'timeout_until' => 0,
        // ... other self-exclusion settings
    ]
]
```

#### Set Self-Exclusion

Update the self-exclusion settings:

```php
$params = [
    'max_balance' => 50000,
    'max_turnover' => 2500,
    'max_losses' => 500,
    'max_7day_turnover' => 5000,
    'max_7day_losses' => 2500
];

$response = $account->setSelfExclusion($params);
```

Example response:
```php
[
    'set_self_exclusion' => 1
]
```

## Error Handling

When using the Account API, you should always handle potential errors. The API will return error responses in the following format:

```php
[
    'error' => [
        'code' => 'ErrorCode',
        'message' => 'Error message description'
    ]
]
```

Example of error handling:

```php
$response = $account->getAccountInfo();

if (isset($response['error'])) {
    // Handle the error
    $errorCode = $response['error']['code'];
    $errorMessage = $response['error']['message'];
    
    echo "Error ($errorCode): $errorMessage";
} else {
    // Process the successful response
    $accountStatus = $response['get_account_status'];
    // ...
}
```

## Examples

### Complete Authentication Flow

```php
use Rndwiga\DerivApis\Client\DerivClient;
use Rndwiga\DerivApis\Api\Account;

// Create a new DerivClient instance
$client = new DerivClient('your-app-id');

// Create a new Account instance
$account = new Account($client);

// Authenticate with the API
$authResponse = $account->authorize('your-api-token');

if (isset($authResponse['error'])) {
    echo "Authentication failed: " . $authResponse['error']['message'];
    exit;
}

// Successfully authenticated
echo "Authenticated as: " . $authResponse['authorize']['email'];

// Get account balance
$balanceResponse = $account->getBalance();

if (isset($balanceResponse['error'])) {
    echo "Failed to get balance: " . $balanceResponse['error']['message'];
} else {
    echo "Account balance: " . $balanceResponse['balance']['balance'] . " " . $balanceResponse['balance']['currency'];
}

// Logout when done
$account->logout();
```

### Updating Account Settings

```php
use Rndwiga\DerivApis\Client\DerivClient;
use Rndwiga\DerivApis\Api\Account;

// Create a new DerivClient instance
$client = new DerivClient('your-app-id');

// Create a new Account instance
$account = new Account($client);

// Authenticate with the API
$account->authorize('your-api-token');

// Get current settings
$currentSettings = $account->getSettings();

if (isset($currentSettings['error'])) {
    echo "Failed to get settings: " . $currentSettings['error']['message'];
    exit;
}

// Update some settings
$newSettings = [
    'address_line_1' => '789 Updated St',
    'address_city' => 'San Francisco',
    'address_state' => 'CA',
    'address_postcode' => '94105'
];

$updateResponse = $account->setSettings($newSettings);

if (isset($updateResponse['error'])) {
    echo "Failed to update settings: " . $updateResponse['error']['message'];
} else {
    echo "Settings updated successfully!";
}

// Logout when done
$account->logout();
```

This guide should help you get started with using the Account API. For more detailed information about the API endpoints and parameters, please refer to the [official Deriv API documentation](https://developers.deriv.com/docs/account-apis).


`
  [
    {
      "acct": "CR3343724",
      "token": "a1-bQ58lNAbLkrDNyaKIIaREljSdYP7D",
      "cur": "USD"
    }
  ]
`