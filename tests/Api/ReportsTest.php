<?php

use Rndwiga\DerivApis\Api\Reports;
use Rndwiga\DerivApis\Client\DerivClient;

// Test getStatement method
test('getStatement sends correct request', function () {
    $expectedResponse = ['statement' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getStatement();
    
    expect($result)->toBe($expectedResponse);
});

// Test getStatement method with parameters
test('getStatement with parameters sends correct request', function () {
    $params = [
        'limit' => 5,
        'offset' => 0,
        'date_from' => strtotime('-7 days'),
        'date_to' => time()
    ];
    $expectedResponse = ['statement' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getStatement($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getProfitTable method
test('getProfitTable sends correct request', function () {
    $expectedResponse = ['profit_table' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getProfitTable();
    
    expect($result)->toBe($expectedResponse);
});

// Test getProfitTable method with parameters
test('getProfitTable with parameters sends correct request', function () {
    $params = [
        'limit' => 5,
        'offset' => 0,
        'date_from' => strtotime('-30 days'),
        'date_to' => time(),
        'sort' => 'DESC'
    ];
    $expectedResponse = ['profit_table' => ['transactions' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getProfitTable($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getTransactionDetails method
test('getTransactionDetails sends correct request', function () {
    $contractId = '123456';
    $expectedResponse = ['transaction' => ['details' => ['contract_id' => '123456']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getTransactionDetails($contractId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getFinancialAssessment method
test('getFinancialAssessment sends correct request', function () {
    $expectedResponse = ['get_financial_assessment' => ['financial_assessment' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getFinancialAssessment();
    
    expect($result)->toBe($expectedResponse);
});

// Test setFinancialAssessment method
test('setFinancialAssessment sends correct request', function () {
    $params = [
        'education_level' => 'Secondary',
        'employment_industry' => 'Finance',
        'estimated_worth' => '$100,000 - $250,000',
        'income_source' => 'Salaried Employee',
        'net_income' => '$25,000 - $50,000',
        'occupation' => 'Financial Advisor'
    ];
    $expectedResponse = ['set_financial_assessment' => ['success' => 1]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->setFinancialAssessment($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getTradingDurations method
test('getTradingDurations sends correct request', function () {
    $expectedResponse = ['trading_durations' => ['durations' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getTradingDurations();
    
    expect($result)->toBe($expectedResponse);
});

// Test getAccountStatus method
test('getAccountStatus sends correct request', function () {
    $expectedResponse = ['get_account_status' => ['status' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getAccountStatus();
    
    expect($result)->toBe($expectedResponse);
});

// Test getPortfolio method
test('getPortfolio sends correct request', function () {
    $expectedResponse = ['portfolio' => ['contracts' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getPortfolio();
    
    expect($result)->toBe($expectedResponse);
});

// Test getPortfolio method with parameters
test('getPortfolio with parameters sends correct request', function () {
    $params = [
        'contract_type' => 'CALL',
        'limit' => 5
    ];
    $expectedResponse = ['portfolio' => ['contracts' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getPortfolio($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test subscribeTransactions method
test('subscribeTransactions sends correct request', function () {
    $expectedResponse = ['transaction' => ['subscription' => ['id' => '123']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->subscribeTransactions();
    
    expect($result)->toBe($expectedResponse);
});

// Test getOpenPositions method
test('getOpenPositions sends correct request', function () {
    $expectedResponse = ['proposal_open_contract' => ['contracts' => []]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getOpenPositions();
    
    expect($result)->toBe($expectedResponse);
});

// Test getLimitsAndSelfExclusion method
test('getLimitsAndSelfExclusion sends correct request', function () {
    $expectedResponse = [
        'get_limits' => ['limits' => []],
        'get_self_exclusion' => ['self_exclusion' => []]
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $reports = new Reports($mockClient);
    
    $result = $reports->getLimitsAndSelfExclusion();
    
    expect($result)->toBe($expectedResponse);
});