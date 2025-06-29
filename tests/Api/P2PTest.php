<?php

use Rndwiga\DerivApis\Api\P2P;
use Rndwiga\DerivApis\Client\DerivClient;

// Test getAdvertiserInfo method without ID
test('getAdvertiserInfo without ID sends correct request', function () {
    $expectedResponse = ['p2p_advertiser_info' => ['id' => 12345, 'name' => 'Test Advertiser']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getAdvertiserInfo();
    
    expect($result)->toBe($expectedResponse);
});

// Test getAdvertiserInfo method with ID
test('getAdvertiserInfo with ID sends correct request', function () {
    $advertiserId = 12345;
    $expectedResponse = ['p2p_advertiser_info' => ['id' => $advertiserId, 'name' => 'Test Advertiser']];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getAdvertiserInfo($advertiserId);
    
    expect($result)->toBe($expectedResponse);
});

// Test createAdvertiser method
test('createAdvertiser sends correct request', function () {
    $params = [
        'name' => 'Test Advertiser',
        'contact_info' => 'Contact information',
        'default_advert_description' => 'Default advertisement description'
    ];
    
    $expectedResponse = ['p2p_advertiser_create' => ['id' => 12345]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->createAdvertiser($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test updateAdvertiser method
test('updateAdvertiser sends correct request', function () {
    $params = [
        'contact_info' => 'Updated contact information',
        'default_advert_description' => 'Updated default description'
    ];
    
    $expectedResponse = ['p2p_advertiser_update' => ['id' => 12345]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->updateAdvertiser($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAdvertisements method without parameters
test('getAdvertisements without parameters sends correct request', function () {
    $expectedResponse = ['p2p_advert_list' => ['list' => [['id' => 12345]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getAdvertisements();
    
    expect($result)->toBe($expectedResponse);
});

// Test getAdvertisements method with parameters
test('getAdvertisements with parameters sends correct request', function () {
    $params = [
        'limit' => 5,
        'offset' => 0
    ];
    
    $expectedResponse = ['p2p_advert_list' => ['list' => [['id' => 12345]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getAdvertisements($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getAdvertisementInfo method
test('getAdvertisementInfo sends correct request', function () {
    $advertId = 12345;
    $expectedResponse = ['p2p_advert_info' => ['id' => $advertId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getAdvertisementInfo($advertId);
    
    expect($result)->toBe($expectedResponse);
});

// Test createAdvertisement method
test('createAdvertisement sends correct request', function () {
    $params = [
        'type' => 'buy',
        'amount' => 100,
        'max_order_amount' => 1000,
        'min_order_amount' => 10,
        'payment_method' => 'bank_transfer',
        'rate' => 1.05,
        'rate_type' => 'fixed'
    ];
    
    $expectedResponse = ['p2p_advert_create' => ['id' => 12345]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->createAdvertisement($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test updateAdvertisement method
test('updateAdvertisement sends correct request', function () {
    $advertId = 12345;
    $params = [
        'max_order_amount' => 2000,
        'min_order_amount' => 20,
        'rate' => 1.10
    ];
    
    $expectedResponse = ['p2p_advert_update' => ['id' => $advertId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->updateAdvertisement($advertId, $params);
    
    expect($result)->toBe($expectedResponse);
});

// Test deleteAdvertisement method
test('deleteAdvertisement sends correct request', function () {
    $advertId = 12345;
    $expectedResponse = ['p2p_advert_delete' => ['id' => $advertId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->deleteAdvertisement($advertId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getOrders method without parameters
test('getOrders without parameters sends correct request', function () {
    $expectedResponse = ['p2p_order_list' => ['list' => [['id' => 12345]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getOrders();
    
    expect($result)->toBe($expectedResponse);
});

// Test getOrders method with parameters
test('getOrders with parameters sends correct request', function () {
    $params = [
        'limit' => 5,
        'offset' => 0
    ];
    
    $expectedResponse = ['p2p_order_list' => ['list' => [['id' => 12345]]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getOrders($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test getOrderInfo method
test('getOrderInfo sends correct request', function () {
    $orderId = 12345;
    $expectedResponse = ['p2p_order_info' => ['id' => $orderId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getOrderInfo($orderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test createOrder method
test('createOrder sends correct request', function () {
    $params = [
        'advert_id' => 12345,
        'amount' => 50
    ];
    
    $expectedResponse = ['p2p_order_create' => ['id' => 67890]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->createOrder($params);
    
    expect($result)->toBe($expectedResponse);
});

// Test confirmOrderPayment method
test('confirmOrderPayment sends correct request', function () {
    $orderId = 12345;
    $expectedResponse = ['p2p_order_confirm' => ['id' => $orderId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->confirmOrderPayment($orderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test cancelOrder method
test('cancelOrder sends correct request', function () {
    $orderId = 12345;
    $expectedResponse = ['p2p_order_cancel' => ['id' => $orderId]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->cancelOrder($orderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test getPaymentMethods method
test('getPaymentMethods sends correct request', function () {
    $expectedResponse = ['p2p_payment_methods' => ['methods' => ['bank_transfer', 'alipay']]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getPaymentMethods();
    
    expect($result)->toBe($expectedResponse);
});

// Test getChatMessages method
test('getChatMessages sends correct request', function () {
    $orderId = 12345;
    $expectedResponse = ['p2p_chat_messages' => ['list' => [['message' => 'Hello']]]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->getChatMessages($orderId);
    
    expect($result)->toBe($expectedResponse);
});

// Test sendChatMessage method
test('sendChatMessage sends correct request', function () {
    $orderId = 12345;
    $message = 'Hello, this is a test message.';
    $expectedResponse = ['p2p_chat_create' => ['id' => 67890]];
    $mockClient = createSimpleMockClient($expectedResponse);
    $p2p = new P2P($mockClient);
    
    $result = $p2p->sendChatMessage($orderId, $message);
    
    expect($result)->toBe($expectedResponse);
});