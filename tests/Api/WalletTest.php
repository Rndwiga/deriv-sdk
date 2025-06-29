<?php

use Rndwiga\DerivApis\Api\Wallet;
use Rndwiga\DerivApis\Client\DerivClient;

// Mock the DerivClient to avoid actual API calls
beforeEach(function () {
    $this->mockClient = Mockery::mock(DerivClient::class);
    $this->wallet = new Wallet($this->mockClient);
});

// Clean up Mockery after each test
afterEach(function () {
    Mockery::close();
});

// Test getWalletAccounts method
test('getWalletAccounts sends correct request', function () {
    $expectedResponse = ['wallet_accounts' => ['some' => 'data']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['wallet_accounts' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->wallet->getWalletAccounts();
    
    expect($result)->toBe($expectedResponse);
});

// Test createWalletAccount method
test('createWalletAccount sends correct request', function () {
    $params = [
        'currency' => 'BTC',
        'name' => 'My Bitcoin Wallet'
    ];
    
    $expectedResponse = ['wallet_create' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['wallet_create' => 1], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->wallet->createWalletAccount($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getWalletTransactions method
test('getWalletTransactions sends correct request', function () {
    $walletId = 'WALLET123';
    $params = [
        'limit' => 5,
        'offset' => 0
    ];
    
    $expectedResponse = ['wallet_transactions' => ['some' => 'data']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge([
            'wallet_transactions' => 1,
            'wallet_id' => $walletId
        ], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->wallet->getWalletTransactions($walletId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test transferBetweenWallets method
test('transferBetweenWallets sends correct request', function () {
    $params = [
        'from_wallet' => 'WALLET123',
        'to_wallet' => 'WALLET456',
        'amount' => 0.001,
        'currency' => 'BTC'
    ];
    
    $expectedResponse = ['wallet_transfer' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['wallet_transfer' => 1], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->wallet->transferBetweenWallets($params);
    
    expect($result)->toBe($expectedResponse);
});