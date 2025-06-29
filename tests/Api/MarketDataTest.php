<?php

use Rndwiga\DerivApis\Api\MarketData;
use Rndwiga\DerivApis\Client\DerivClient;

// Test getTicks method
test('getTicks sends correct request', function () {
    $symbol = 'R_100';
    $count = 10;
    $expectedResponse = ['ticks' => ['prices' => [1, 2, 3, 4, 5]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getTicks($symbol, $count);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribeTicks method
test('subscribeTicks sends correct request', function () {
    $symbol = 'R_100';
    $expectedResponse = ['tick' => ['quote' => 123.45], 'subscription' => ['id' => '123abc']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->subscribeTicks($symbol);
    
    expect($result)->toBe($expectedResponse);
});

// Test getCandles method
test('getCandles sends correct request', function () {
    $symbol = 'R_100';
    $count = 10;
    $granularity = 60;
    $expectedResponse = ['candles' => [['open' => 100, 'high' => 101, 'low' => 99, 'close' => 100.5]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getCandles($symbol, $count, $granularity);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribeCandles method
test('subscribeCandles sends correct request', function () {
    $symbol = 'R_100';
    $granularity = 60;
    $expectedResponse = ['ohlc' => ['open' => 100, 'high' => 101, 'low' => 99, 'close' => 100.5], 'subscription' => ['id' => '456def']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->subscribeCandles($symbol, $granularity);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPriceProposal method
test('getPriceProposal sends correct request', function () {
    $contractParams = [
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'amount' => 10,
        'basis' => 'payout'
    ];
    $expectedResponse = ['proposal' => ['ask_price' => 5.25, 'payout' => 10]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getPriceProposal($contractParams);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribePriceProposal method
test('subscribePriceProposal sends correct request', function () {
    $contractParams = [
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'amount' => 10,
        'basis' => 'payout'
    ];
    $expectedResponse = ['proposal' => ['ask_price' => 5.25, 'payout' => 10], 'subscription' => ['id' => '789ghi']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->subscribePriceProposal($contractParams);
    
    expect($result)->toBe($expectedResponse);
});

// Test getActiveSymbols method
test('getActiveSymbols sends correct request', function () {
    $productType = 'basic';
    $expectedResponse = ['active_symbols' => [['symbol' => 'R_100', 'display_name' => 'Volatility 100 Index']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getActiveSymbols($productType);
    
    expect($result)->toBe($expectedResponse);
});

// Test getSymbolDetails method
test('getSymbolDetails sends correct request', function () {
    $symbol = 'R_100';
    $expectedResponse = ['symbol_details' => ['symbol' => 'R_100', 'display_name' => 'Volatility 100 Index']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getSymbolDetails($symbol);
    
    expect($result)->toBe($expectedResponse);
});

// Test getTradingTimes method with date
test('getTradingTimes with date sends correct request', function () {
    $date = '2023-01-01';
    $expectedResponse = ['trading_times' => ['markets' => [['name' => 'Forex', 'submarkets' => []]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getTradingTimes($date);
    
    expect($result)->toBe($expectedResponse);
});

// Test getTradingTimes method without date
test('getTradingTimes without date sends correct request', function () {
    $expectedResponse = ['trading_times' => ['markets' => [['name' => 'Forex', 'submarkets' => []]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getTradingTimes();
    
    expect($result)->toBe($expectedResponse);
});

// Test getServerTime method
test('getServerTime sends correct request', function () {
    $expectedResponse = ['time' => 1609459200];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->getServerTime();
    
    expect($result)->toBe($expectedResponse);
});

// Test cancelSubscription method
test('cancelSubscription sends correct request', function () {
    $id = '123abc';
    $expectedResponse = ['forget' => '123abc'];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->cancelSubscription($id);
    
    expect($result)->toBe($expectedResponse);
});

// Test cancelAllSubscriptions method
test('cancelAllSubscriptions sends correct request', function () {
    $type = 'ticks';
    $expectedResponse = ['forget_all' => ['ticks']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $marketData = new MarketData($mockClient);
    
    $result = $marketData->cancelAllSubscriptions($type);
    
    expect($result)->toBe($expectedResponse);
});