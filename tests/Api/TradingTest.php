<?php

use Rndwiga\DerivApis\Api\Trading;
use Rndwiga\DerivApis\Client\DerivClient;

// Test buyContract method
test('buyContract sends correct request', function () {
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $expectedResponse = ['buy' => ['contract_id' => '123456', 'longcode' => 'Win payout if R_100 rises']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->buyContract($contractParams);
    
    expect($result)->toBe($expectedResponse);
});

// Test sellContract method
test('sellContract sends correct request', function () {
    $contractId = '123456';
    $expectedResponse = ['sell' => ['sold_for' => 5.23]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->sellContract($contractId);
    
    expect($result)->toBe($expectedResponse);
});

// Test sellContract method with price
test('sellContract with price sends correct request', function () {
    $contractId = '123456';
    $price = 5.50;
    $expectedResponse = ['sell' => ['sold_for' => 5.50]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->sellContract($contractId, $price);
    
    expect($result)->toBe($expectedResponse);
});

// Test getContractInfo method
test('getContractInfo sends correct request', function () {
    $contractId = '123456';
    $expectedResponse = ['proposal_open_contract' => ['contract_id' => '123456', 'status' => 'open']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getContractInfo($contractId);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribeContractInfo method
test('subscribeContractInfo sends correct request', function () {
    $contractId = '123456';
    $expectedResponse = ['proposal_open_contract' => ['contract_id' => '123456', 'status' => 'open']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->subscribeContractInfo($contractId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPriceProposal method
test('getPriceProposal sends correct request', function () {
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $expectedResponse = ['proposal' => ['id' => 'abc123', 'ask_price' => 5.23]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getPriceProposal($contractParams);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribePriceProposal method
test('subscribePriceProposal sends correct request', function () {
    $contractParams = [
        'contract_type' => 'CALL',
        'symbol' => 'R_100',
        'duration' => 60,
        'duration_unit' => 's',
        'currency' => 'USD',
        'amount' => 10
    ];
    
    $expectedResponse = ['proposal' => ['id' => 'abc123', 'ask_price' => 5.23]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->subscribePriceProposal($contractParams);
    
    expect($result)->toBe($expectedResponse);
});

// Test cancelContract method
test('cancelContract sends correct request', function () {
    $contractId = '123456';
    $expectedResponse = ['cancel' => ['balance_after' => 1000.00]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->cancelContract($contractId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPayoutCurrencies method
test('getPayoutCurrencies sends correct request', function () {
    $expectedResponse = ['payout_currencies' => ['USD', 'EUR', 'GBP']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getPayoutCurrencies();
    
    expect($result)->toBe($expectedResponse);
});

// Test getContractTypes method
test('getContractTypes sends correct request', function () {
    $symbol = 'R_100';
    $expectedResponse = ['contracts_for' => ['available' => ['CALL', 'PUT']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getContractTypes($symbol);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPriceForPayout method
test('getPriceForPayout sends correct request', function () {
    $params = [
        'proposal' => 1,
        'amount' => 100,
        'basis' => 'payout',
        'contract_type' => 'CALL',
        'currency' => 'USD',
        'duration' => 60,
        'duration_unit' => 's',
        'symbol' => 'R_100'
    ];
    
    $expectedResponse = ['price' => ['ask_price' => 50.25]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getPriceForPayout($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test updateContract method
test('updateContract sends correct request', function () {
    $contractId = '123456';
    $params = ['price' => 100];
    
    $expectedResponse = ['contract_update' => ['contract_id' => '123456', 'updated_price' => 100]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->updateContract($contractId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getProfitTable method
test('getProfitTable sends correct request', function () {
    $params = [
        'limit' => 10,
        'offset' => 0,
        'sort' => 'DESC'
    ];
    
    $expectedResponse = ['profit_table' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getProfitTable($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getProfitTable method with no parameters
test('getProfitTable with no parameters sends correct request', function () {
    $expectedResponse = ['profit_table' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getProfitTable();
    
    expect($result)->toBe($expectedResponse);
});

// Test getPortfolio method
test('getPortfolio sends correct request', function () {
    $params = [
        'contract_type' => 'CALL'
    ];
    
    $expectedResponse = ['portfolio' => ['contracts' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getPortfolio($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPortfolio method with no parameters
test('getPortfolio with no parameters sends correct request', function () {
    $expectedResponse = ['portfolio' => ['contracts' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $trading = new Trading($mockClient);
    
    $result = $trading->getPortfolio();
    
    expect($result)->toBe($expectedResponse);
});