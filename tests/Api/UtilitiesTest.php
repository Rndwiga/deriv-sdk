<?php

use Rndwiga\DerivApis\Api\Utilities;
use Rndwiga\DerivApis\Client\DerivClient;

// Test ping method
test('ping sends correct request', function () {
    $expectedResponse = ['ping' => 'pong'];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->ping();
    
    expect($result)->toBe($expectedResponse);
});

// Test getServerTime method
test('getServerTime sends correct request', function () {
    $expectedResponse = ['time' => 1609459200];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getServerTime();
    
    expect($result)->toBe($expectedResponse);
});

// Test getWebsiteStatus method
test('getWebsiteStatus sends correct request', function () {
    $expectedResponse = ['website_status' => ['site_status' => 'up']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getWebsiteStatus();
    
    expect($result)->toBe($expectedResponse);
});

// Test getExchangeRates method with only base currency
test('getExchangeRates with only base currency sends correct request', function () {
    $baseCurrency = 'USD';
    $expectedResponse = ['exchange_rates' => ['base_currency' => 'USD', 'rates' => ['EUR' => 0.85]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getExchangeRates($baseCurrency);
    
    expect($result)->toBe($expectedResponse);
});

// Test getExchangeRates method with base currency and target currencies
test('getExchangeRates with base currency and target currencies sends correct request', function () {
    $baseCurrency = 'USD';
    $targetCurrencies = ['EUR', 'GBP', 'AUD'];
    $expectedResponse = ['exchange_rates' => ['base_currency' => 'USD', 'rates' => ['EUR' => 0.85, 'GBP' => 0.75, 'AUD' => 1.35]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getExchangeRates($baseCurrency, $targetCurrencies);
    
    expect($result)->toBe($expectedResponse);
});

// Test getCountriesList method
test('getCountriesList sends correct request', function () {
    $expectedResponse = ['residence_list' => [['text' => 'United States', 'value' => 'us']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getCountriesList();
    
    expect($result)->toBe($expectedResponse);
});

// Test getStatesList method
test('getStatesList sends correct request', function () {
    $countryCode = 'us';
    $expectedResponse = ['states_list' => [['text' => 'California', 'value' => 'CA']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getStatesList($countryCode);
    
    expect($result)->toBe($expectedResponse);
});

// Test verifyEmail method
test('verifyEmail sends correct request', function () {
    $email = 'test@example.com';
    $type = 'account_opening';
    $expectedResponse = ['verify_email' => ['success' => 1]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->verifyEmail($email, $type);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAppInfo method
test('getAppInfo sends correct request', function () {
    $appId = 12345;
    $expectedResponse = ['app_get' => ['name' => 'Test App']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getAppInfo($appId);
    
    expect($result)->toBe($expectedResponse);
});

// Test registerApp method
test('registerApp sends correct request', function () {
    $params = [
        'name' => 'Test App',
        'scopes' => ['read', 'trade'],
        'redirect_uri' => 'https://example.com/callback'
    ];
    
    $expectedResponse = ['app_register' => ['app_id' => 12345]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->registerApp($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test updateApp method
test('updateApp sends correct request', function () {
    $appId = 12345;
    $params = [
        'name' => 'Updated Test App',
        'scopes' => ['read', 'trade', 'payments']
    ];
    
    $expectedResponse = ['app_update' => ['success' => 1]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->updateApp($appId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test deleteApp method
test('deleteApp sends correct request', function () {
    $appId = 12345;
    $expectedResponse = ['app_delete' => ['success' => 1]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->deleteApp($appId);
    
    expect($result)->toBe($expectedResponse);
});

// Test listApps method
test('listApps sends correct request', function () {
    $expectedResponse = ['app_list' => [['name' => 'Test App', 'app_id' => 12345]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->listApps();
    
    expect($result)->toBe($expectedResponse);
});

// Test getApiTokenScopes method
test('getApiTokenScopes sends correct request', function () {
    $expectedResponse = ['api_token' => ['scopes' => ['read', 'trade', 'payments']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->getApiTokenScopes();
    
    expect($result)->toBe($expectedResponse);
});

// Test createApiToken method
test('createApiToken sends correct request', function () {
    $params = [
        'name' => 'Test Token',
        'scopes' => ['read', 'trade']
    ];
    
    $expectedResponse = ['api_token' => ['token' => 'a1b2c3d4e5f6']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->createApiToken($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test deleteApiToken method
test('deleteApiToken sends correct request', function () {
    $token = 'a1b2c3d4e5f6';
    $expectedResponse = ['api_token' => ['delete_token' => 1, 'success' => 1]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $utilities = new Utilities($mockClient);
    
    $result = $utilities->deleteApiToken($token);
    
    expect($result)->toBe($expectedResponse);
});