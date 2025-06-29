<?php

use Rndwiga\DerivApis\Api\CopyTrading;
use Rndwiga\DerivApis\Client\DerivClient;

// Mock the DerivClient to avoid actual API calls
beforeEach(function () {
    $this->mockClient = Mockery::mock(DerivClient::class);
    $this->copyTrading = new CopyTrading($this->mockClient);
});

// Clean up Mockery after each test
afterEach(function () {
    Mockery::close();
});

// Test getCopyTradingList method
test('getCopyTradingList sends correct request', function () {
    $params = [
        'limit' => 10,
        'offset' => 0
    ];
    
    $expectedResponse = ['copy_trading_list' => ['some' => 'data']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['copy_trading_list' => 1], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->copyTrading->getCopyTradingList($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test startCopyTrading method
test('startCopyTrading sends correct request', function () {
    $traderId = 'CR12345';
    $params = [
        'max_amount' => 100,
        'assets' => ['forex', 'indices']
    ];
    
    $expectedResponse = ['copy_start' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['copy_start' => 1, 'trader_id' => $traderId], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->copyTrading->startCopyTrading($traderId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test stopCopyTrading method
test('stopCopyTrading sends correct request', function () {
    $traderId = 'CR12345';
    
    $expectedResponse = ['copy_stop' => ['success' => 1]];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['copy_stop' => 1, 'trader_id' => $traderId])
        ->andReturn($expectedResponse);
    
    $result = $this->copyTrading->stopCopyTrading($traderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getCopyTradingStatistics method
test('getCopyTradingStatistics sends correct request', function () {
    $traderId = 'CR12345';
    
    $expectedResponse = ['copy_trading_statistics' => ['some' => 'data']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(['copy_trading_statistics' => 1, 'trader_id' => $traderId])
        ->andReturn($expectedResponse);
    
    $result = $this->copyTrading->getCopyTradingStatistics($traderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getCopyTradingHistory method
test('getCopyTradingHistory sends correct request', function () {
    $params = [
        'date_from' => '2023-01-01',
        'date_to' => '2023-01-31',
        'limit' => 10
    ];
    
    $expectedResponse = ['copy_trading_history' => ['some' => 'data']];
    
    $this->mockClient->shouldReceive('sendRequest')
        ->once()
        ->with(array_merge(['copy_trading_history' => 1], $params))
        ->andReturn($expectedResponse);
    
    $result = $this->copyTrading->getCopyTradingHistory($params);
    
    expect($result)->toBe($expectedResponse);
});