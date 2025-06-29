<?php

use Rndwiga\DerivApis\Api\MT5;
use Rndwiga\DerivApis\Client\DerivClient;

// Create a mock client class if not already defined in the test suite
if (!class_exists('MockDerivClient')) {
    class MockDerivClient extends DerivClient
    {
        private $expectedResponse;
        
        public function __construct($expectedResponse)
        {
            $this->expectedResponse = $expectedResponse;
        }
        
        public function sendRequest($request)
        {
            return $this->expectedResponse;
        }
    }
}

// Test getAccountDetails method with no login ID
test('getAccountDetails with no login ID sends correct request', function () {
    $expectedResponse = ['mt5_login_list' => [['login' => '12345', 'balance' => 1000]]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getAccountDetails();
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountDetails method with login ID
test('getAccountDetails with login ID sends correct request', function () {
    $loginId = '12345';
    $expectedResponse = ['mt5_login_list' => [['login' => $loginId, 'balance' => 1000]]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getAccountDetails($loginId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountTypes method
test('getAccountTypes sends correct request', function () {
    $expectedResponse = ['mt5_get_settings' => ['account_types' => ['demo', 'real']]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getAccountTypes();
    
    expect($result)->toBe($expectedResponse);
});

// Test createAccount method
test('createAccount sends correct request', function () {
    $params = [
        'account_type' => 'demo',
        'leverage' => 100,
        'mainPassword' => 'Password123',
        'mt5_account_type' => 'financial'
    ];
    
    $expectedResponse = ['mt5_new_account' => ['login' => '12345', 'account_type' => 'demo']];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->createAccount($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test deposit method
test('deposit sends correct request', function () {
    $loginId = '12345';
    $amount = 100.50;
    
    $expectedResponse = ['mt5_deposit' => ['balance' => 1100.50, 'transaction_id' => 'txn123']];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->deposit($loginId, $amount);
    
    expect($result)->toBe($expectedResponse);
});

// Test withdraw method
test('withdraw sends correct request', function () {
    $loginId = '12345';
    $amount = 50.25;
    
    $expectedResponse = ['mt5_withdrawal' => ['balance' => 950.25, 'transaction_id' => 'txn456']];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->withdraw($loginId, $amount);
    
    expect($result)->toBe($expectedResponse);
});

// Test passwordReset method
test('passwordReset sends correct request', function () {
    $loginId = '12345';
    $passwordType = 'main';
    
    $expectedResponse = ['mt5_password_reset' => ['success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->passwordReset($loginId, $passwordType);
    
    expect($result)->toBe($expectedResponse);
});

// Test passwordChange method
test('passwordChange sends correct request', function () {
    $loginId = '12345';
    $passwordType = 'main';
    $oldPassword = 'OldPass123';
    $newPassword = 'NewPass456';
    
    $expectedResponse = ['mt5_password_change' => ['success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->passwordChange($loginId, $passwordType, $oldPassword, $newPassword);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountBalance method
test('getAccountBalance sends correct request', function () {
    $loginId = '12345';
    
    $expectedResponse = ['mt5_login_list' => [['login' => $loginId, 'balance' => 1000]]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getAccountBalance($loginId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getTransactionHistory method with no parameters
test('getTransactionHistory with no parameters sends correct request', function () {
    $expectedResponse = ['mt5_history' => [['transaction_id' => 'txn123', 'amount' => 100]]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getTransactionHistory();
    
    expect($result)->toBe($expectedResponse);
});

// Test getTransactionHistory method with parameters
test('getTransactionHistory with parameters sends correct request', function () {
    $params = [
        'limit' => 10,
        'offset' => 0,
        'from' => '2023-01-01',
        'to' => '2023-12-31'
    ];
    
    $expectedResponse = ['mt5_history' => [['transaction_id' => 'txn123', 'amount' => 100]]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getTransactionHistory($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test setAccountSettings method
test('setAccountSettings sends correct request', function () {
    $loginId = '12345';
    $settings = [
        'leverage' => 200,
        'name' => 'Updated Name'
    ];
    
    $expectedResponse = ['mt5_set_settings' => ['success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->setAccountSettings($loginId, $settings);
    
    expect($result)->toBe($expectedResponse);
});

// Test getMT5TradeHistory method with no parameters
test('getMT5TradeHistory with no parameters sends correct request', function () {
    $expectedResponse = ['mt5_trade_history' => [['order_id' => 'ord123', 'symbol' => 'EURUSD']]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getMT5TradeHistory();
    
    expect($result)->toBe($expectedResponse);
});

// Test getMT5TradeHistory method with parameters
test('getMT5TradeHistory with parameters sends correct request', function () {
    $params = [
        'login' => '12345',
        'limit' => 10,
        'offset' => 0,
        'from' => '2023-01-01',
        'to' => '2023-12-31'
    ];
    
    $expectedResponse = ['mt5_trade_history' => [['order_id' => 'ord123', 'symbol' => 'EURUSD']]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getMT5TradeHistory($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getMT5OpenPositions method with no parameters
test('getMT5OpenPositions with no parameters sends correct request', function () {
    $expectedResponse = ['mt5_open_positions' => [['position_id' => 'pos123', 'symbol' => 'EURUSD']]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getMT5OpenPositions();
    
    expect($result)->toBe($expectedResponse);
});

// Test getMT5OpenPositions method with parameters
test('getMT5OpenPositions with parameters sends correct request', function () {
    $params = [
        'login' => '12345',
        'limit' => 10,
        'offset' => 0
    ];
    
    $expectedResponse = ['mt5_open_positions' => [['position_id' => 'pos123', 'symbol' => 'EURUSD']]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->getMT5OpenPositions($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test placeMT5Order method
test('placeMT5Order sends correct request', function () {
    $params = [
        'login' => '12345',
        'symbol' => 'EURUSD',
        'type' => 'ORDER_TYPE_BUY',
        'volume' => 0.1,
        'price' => 1.1000
    ];
    
    $expectedResponse = ['mt5_place_order' => ['order_id' => 'ord123', 'success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->placeMT5Order($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test modifyMT5Order method
test('modifyMT5Order sends correct request', function () {
    $orderId = 'ord123';
    $params = [
        'price' => 1.1050,
        'volume' => 0.2
    ];
    
    $expectedResponse = ['mt5_modify_order' => ['order_id' => $orderId, 'success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->modifyMT5Order($orderId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test closeMT5Position method with no additional parameters
test('closeMT5Position with no additional parameters sends correct request', function () {
    $positionId = 'pos123';
    
    $expectedResponse = ['mt5_close_position' => ['position_id' => $positionId, 'success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->closeMT5Position($positionId);
    
    expect($result)->toBe($expectedResponse);
});

// Test closeMT5Position method with additional parameters
test('closeMT5Position with additional parameters sends correct request', function () {
    $positionId = 'pos123';
    $params = [
        'volume' => 0.05 // Partial close
    ];
    
    $expectedResponse = ['mt5_close_position' => ['position_id' => $positionId, 'success' => 1]];
    $mockClient = new MockDerivClient($expectedResponse);
    $mt5 = new MT5($mockClient);
    
    $result = $mt5->closeMT5Position($positionId, $params);
    
    expect($result)->toBe($expectedResponse);
});