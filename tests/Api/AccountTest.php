<?php

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Client\DerivClient;

// Mock the DerivClient to avoid actual API calls
beforeEach(function () {
    $this->mockClient = Mockery::mock(DerivClient::class);
    $this->account = new Account($this->mockClient);
});

// Clean up Mockery after each test
afterEach(function () {
    Mockery::close();
});

// Test getAccountInfo method
test('getAccountInfo sends correct request', function () {
    $expectedResponse = ['get_account_status' => ['status' => 'active']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['get_account_status' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getAccountInfo();
    
    expect($result)->toBe($expectedResponse);
});

// Test getSettings method
test('getSettings sends correct request', function () {
    $expectedResponse = ['get_settings' => ['email' => 'test@example.com']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['get_settings' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getSettings();
    
    expect($result)->toBe($expectedResponse);
});

// Test setSettings method
test('setSettings sends correct request', function () {
    $settings = [
        'email' => 'new@example.com',
        'address_line_1' => '123 Main St'
    ];
    
    $expectedResponse = ['set_settings' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->withArgs(function ($params) use ($settings) {
            return $params['set_settings'] === 1 
                && $params['passthrough'] === $settings 
                && isset($params['request_id']);
        })
        ->andReturn($expectedResponse);
    
    $result = $this->account->setSettings($settings);
    
    expect($result)->toBe($expectedResponse);
});

// Test getLimits method
test('getLimits sends correct request', function () {
    $expectedResponse = ['get_limits' => ['withdrawal_limit' => 1000]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['get_limits' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getLimits();
    
    expect($result)->toBe($expectedResponse);
});

// Test getBalance method without account parameter
test('getBalance without account parameter sends correct request', function () {
    $expectedResponse = ['balance' => ['balance' => 1000, 'currency' => 'USD']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['balance' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getBalance();
    
    expect($result)->toBe($expectedResponse);
});

// Test getBalance method with account parameter
test('getBalance with account parameter sends correct request', function () {
    $account = 'CR123456';
    $expectedResponse = ['balance' => ['balance' => 1000, 'currency' => 'USD']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['balance' => 1, 'account' => $account])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getBalance($account);
    
    expect($result)->toBe($expectedResponse);
});

// Test getSelfExclusion method
test('getSelfExclusion sends correct request', function () {
    $expectedResponse = ['get_self_exclusion' => ['max_losses' => 1000]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['get_self_exclusion' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->getSelfExclusion();
    
    expect($result)->toBe($expectedResponse);
});

// Test setSelfExclusion method
test('setSelfExclusion sends correct request', function () {
    $params = [
        'max_losses' => 500,
        'max_turnover' => 1000
    ];
    
    $expectedResponse = ['set_self_exclusion' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['set_self_exclusion' => 1], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->account->setSelfExclusion($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test authorize method
test('authorize sends correct request', function () {
    $token = 'a1b2c3d4e5f6';
    $expectedResponse = ['authorize' => ['email' => 'test@example.com']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['authorize' => $token])
        ->andReturn($expectedResponse);
    
    $result = $this->account->authorize($token);
    
    expect($result)->toBe($expectedResponse);
});

// Test logout method
test('logout sends correct request', function () {
    $expectedResponse = ['logout' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['logout' => 1])
        ->andReturn($expectedResponse);
    
    $result = $this->account->logout();
    
    expect($result)->toBe($expectedResponse);
});