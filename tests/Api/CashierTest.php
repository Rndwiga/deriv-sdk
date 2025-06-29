<?php

use Rndwiga\DerivApis\Api\Cashier;
use Rndwiga\DerivApis\Client\DerivClient;

// Test getCashierInfo method
test('getCashierInfo sends correct request', function () {
    $expectedResponse = ['cashier' => ['info' => ['details' => 'some info']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getCashierInfo();
    
    expect($result)->toBe($expectedResponse);
});

// Test getCashierInfo method with verification code
test('getCashierInfo with verification code sends correct request', function () {
    $verificationCode = 'abc123';
    $expectedResponse = ['cashier' => ['info' => ['details' => 'some info']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getCashierInfo($verificationCode);
    
    expect($result)->toBe($expectedResponse);
});

// Test getDepositInfo method
test('getDepositInfo sends correct request', function () {
    $expectedResponse = ['cashier' => ['deposit' => ['address' => 'deposit_address']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getDepositInfo();
    
    expect($result)->toBe($expectedResponse);
});

// Test getDepositInfo method with verification code
test('getDepositInfo with verification code sends correct request', function () {
    $verificationCode = 'abc123';
    $expectedResponse = ['cashier' => ['deposit' => ['address' => 'deposit_address']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getDepositInfo($verificationCode);
    
    expect($result)->toBe($expectedResponse);
});

// Test getWithdrawalInfo method
test('getWithdrawalInfo sends correct request', function () {
    $expectedResponse = ['cashier' => ['withdraw' => ['info' => 'withdrawal_info']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getWithdrawalInfo();
    
    expect($result)->toBe($expectedResponse);
});

// Test getWithdrawalInfo method with verification code
test('getWithdrawalInfo with verification code sends correct request', function () {
    $verificationCode = 'abc123';
    $expectedResponse = ['cashier' => ['withdraw' => ['info' => 'withdrawal_info']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getWithdrawalInfo($verificationCode);
    
    expect($result)->toBe($expectedResponse);
});

// Test transferBetweenAccounts method
test('transferBetweenAccounts sends correct request', function () {
    $params = [
        'account_from' => 'CR123456',
        'account_to' => 'CR654321',
        'amount' => 100.00,
        'currency' => 'USD'
    ];
    
    $expectedResponse = ['transfer_between_accounts' => ['transaction_id' => 'txn_123456']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->transferBetweenAccounts($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountTransferHistory method
test('getAccountTransferHistory sends correct request', function () {
    $expectedResponse = ['account_transfer_history' => [
        ['transaction_id' => 'txn_123456', 'amount' => 100.00, 'currency' => 'USD']
    ]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getAccountTransferHistory();
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountTransferHistory method with parameters
test('getAccountTransferHistory with parameters sends correct request', function () {
    $params = [
        'limit' => 10,
        'offset' => 0
    ];
    
    $expectedResponse = ['account_transfer_history' => [
        ['transaction_id' => 'txn_123456', 'amount' => 100.00, 'currency' => 'USD']
    ]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getAccountTransferHistory($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getCryptoCurrenciesConfig method
test('getCryptoCurrenciesConfig sends correct request', function () {
    $expectedResponse = ['crypto_config' => [
        'currencies' => ['BTC', 'ETH', 'LTC']
    ]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getCryptoCurrenciesConfig();
    
    expect($result)->toBe($expectedResponse);
});

// Test getPaymentMethods method
test('getPaymentMethods sends correct request', function () {
    $countryCode = 'us';
    $expectedResponse = ['payment_methods' => [
        ['method' => 'bank_transfer', 'currencies' => ['USD', 'EUR']]
    ]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $cashier = new Cashier($mockClient);
    
    $result = $cashier->getPaymentMethods($countryCode);
    
    expect($result)->toBe($expectedResponse);
});