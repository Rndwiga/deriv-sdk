<?php

use Rndwiga\DerivApis\Api\EconomicCalendar;
use Rndwiga\DerivApis\Client\DerivClient;

// Test getEconomicCalendar method with no parameters
test('getEconomicCalendar with no parameters sends correct request', function () {
    $expectedResponse = [
        'economic_calendar' => [
            ['event_id' => 'event1', 'title' => 'GDP Report', 'date' => '2023-06-15'],
            ['event_id' => 'event2', 'title' => 'Interest Rate Decision', 'date' => '2023-06-16']
        ]
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $economicCalendar = new EconomicCalendar($mockClient);

    $result = $economicCalendar->getEconomicCalendar();

    expect($result)->toBe($expectedResponse);
});

// Test getEconomicCalendar method with parameters
test('getEconomicCalendar with parameters sends correct request', function () {
    $params = [
        'date_from' => '2023-06-01',
        'date_to' => '2023-06-30',
        'count' => 10
    ];
    $expectedResponse = [
        'economic_calendar' => [
            ['event_id' => 'event1', 'title' => 'GDP Report', 'date' => '2023-06-15'],
            ['event_id' => 'event2', 'title' => 'Interest Rate Decision', 'date' => '2023-06-16']
        ]
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $economicCalendar = new EconomicCalendar($mockClient);

    $result = $economicCalendar->getEconomicCalendar($params);

    expect($result)->toBe($expectedResponse);
});

// Test getEconomicEvent method
test('getEconomicEvent sends correct request', function () {
    $eventId = 'event123';
    $expectedResponse = [
        'economic_event' => [
            'event_id' => 'event123',
            'title' => 'GDP Report',
            'date' => '2023-06-15',
            'country' => 'US',
            'impact' => 'high',
            'forecast' => '3.2%',
            'previous' => '2.9%'
        ]
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $economicCalendar = new EconomicCalendar($mockClient);

    $result = $economicCalendar->getEconomicEvent($eventId);

    expect($result)->toBe($expectedResponse);
});

// Test subscribeEconomicCalendar method with no parameters
test('subscribeEconomicCalendar with no parameters sends correct request', function () {
    $expectedResponse = [
        'economic_calendar' => [
            ['event_id' => 'event1', 'title' => 'GDP Report', 'date' => '2023-06-15'],
            ['event_id' => 'event2', 'title' => 'Interest Rate Decision', 'date' => '2023-06-16']
        ],
        'subscription' => ['id' => 'abc123']
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $economicCalendar = new EconomicCalendar($mockClient);

    $result = $economicCalendar->subscribeEconomicCalendar();

    expect($result)->toBe($expectedResponse);
});

// Test subscribeEconomicCalendar method with parameters
test('subscribeEconomicCalendar with parameters sends correct request', function () {
    $params = [
        'date_from' => '2023-06-01',
        'date_to' => '2023-06-30'
    ];
    $expectedResponse = [
        'economic_calendar' => [
            ['event_id' => 'event1', 'title' => 'GDP Report', 'date' => '2023-06-15'],
            ['event_id' => 'event2', 'title' => 'Interest Rate Decision', 'date' => '2023-06-16']
        ],
        'subscription' => ['id' => 'abc123']
    ];
    $mockClient = createSimpleMockClient($expectedResponse);
    $economicCalendar = new EconomicCalendar($mockClient);

    $result = $economicCalendar->subscribeEconomicCalendar($params);

    expect($result)->toBe($expectedResponse);
});
