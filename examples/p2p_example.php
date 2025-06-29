<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\P2P;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runAdvertiserOperations = true;
$runAdvertisementOperations = true;
$runOrderOperations = true;
$runPaymentMethodOperations = true;
$runChatOperations = false; // Requires valid order ID

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new P2P instance
    $p2p = new P2P($client);

    // Authenticate with the API (required for most P2P endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Run examples based on feature flags
            if ($runAdvertiserOperations) {
                advertiserOperations($p2p);
            }
            
            if ($runAdvertisementOperations) {
                advertisementOperations($p2p);
            }
            
            if ($runOrderOperations) {
                orderOperations($p2p);
            }
            
            if ($runPaymentMethodOperations) {
                paymentMethodOperations($p2p);
            }
            
            if ($runChatOperations) {
                chatOperations($p2p);
            }
        }
    } else {
        echo "API token not provided. Most P2P operations require authentication.\n";
        
        // We can still demonstrate the structure of the API calls
        echo "\n=== P2P API Structure Examples (Not Executed) ===\n";
        echo "These examples show the structure of P2P API calls but won't be executed without a valid token.\n";
        
        echo "\nTo get advertiser info: \$p2p->getAdvertiserInfo();\n";
        echo "To create an advertiser: \$p2p->createAdvertiser(['name' => 'Example']);\n";
        echo "To get advertisements: \$p2p->getAdvertisements(['limit' => 10]);\n";
        echo "To get payment methods: \$p2p->getPaymentMethods();\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function advertiserOperations(P2P $p2p): void
{
    echo "\n=== Advertiser Operations ===\n";
    
    // Get advertiser info (own account)
    echo "Getting advertiser info for own account...\n";
    $response = $p2p->getAdvertiserInfo();
    
    if (isset($response['error'])) {
        echo "Failed to get advertiser info: " . $response['error']['message'] . "\n";
    } else {
        echo "Advertiser info retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        
        // If we have an advertiser ID, we can use it for other operations
        if (isset($response['p2p_advertiser_info']['id'])) {
            $advertiserId = $response['p2p_advertiser_info']['id'];
            
            // Get specific advertiser info
            echo "\nGetting info for advertiser ID: $advertiserId\n";
            $specificResponse = $p2p->getAdvertiserInfo($advertiserId);
            
            if (isset($specificResponse['error'])) {
                echo "Failed to get specific advertiser info: " . $specificResponse['error']['message'] . "\n";
            } else {
                echo "Specific advertiser info retrieved successfully\n";
                echo "Response: " . json_encode($specificResponse, JSON_PRETTY_PRINT) . "\n";
            }
            
            // Update advertiser
            echo "\nUpdating advertiser...\n";
            $updateParams = [
                'contact_info' => 'Updated contact information',
                'default_advert_description' => 'Updated default description'
            ];
            
            $updateResponse = $p2p->updateAdvertiser($updateParams);
            
            if (isset($updateResponse['error'])) {
                echo "Failed to update advertiser: " . $updateResponse['error']['message'] . "\n";
            } else {
                echo "Advertiser updated successfully\n";
                echo "Response: " . json_encode($updateResponse, JSON_PRETTY_PRINT) . "\n";
            }
        } else {
            // Create advertiser if not exists
            echo "\nCreating new advertiser...\n";
            $createParams = [
                'name' => 'Example Advertiser',
                'contact_info' => 'Contact information',
                'default_advert_description' => 'Default advertisement description'
            ];
            
            $createResponse = $p2p->createAdvertiser($createParams);
            
            if (isset($createResponse['error'])) {
                echo "Failed to create advertiser: " . $createResponse['error']['message'] . "\n";
            } else {
                echo "Advertiser created successfully\n";
                echo "Response: " . json_encode($createResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
    }
}

function advertisementOperations(P2P $p2p): void
{
    echo "\n=== Advertisement Operations ===\n";
    
    // Get advertisements
    echo "Getting advertisements...\n";
    $params = [
        'limit' => 5,
        'offset' => 0
    ];
    
    $response = $p2p->getAdvertisements($params);
    
    if (isset($response['error'])) {
        echo "Failed to get advertisements: " . $response['error']['message'] . "\n";
    } else {
        echo "Advertisements retrieved successfully\n";
        echo "Total advertisements: " . (isset($response['p2p_advert_list']['list']) ? count($response['p2p_advert_list']['list']) : 0) . "\n";
        
        // Don't print the full list as it would be too long
        echo "First few advertisements: " . json_encode(array_slice($response['p2p_advert_list']['list'] ?? [], 0, 2), JSON_PRETTY_PRINT) . "\n";
        
        // If we have an advertisement ID, we can use it for other operations
        if (isset($response['p2p_advert_list']['list'][0]['id'])) {
            $advertId = $response['p2p_advert_list']['list'][0]['id'];
            
            // Get advertisement info
            echo "\nGetting info for advertisement ID: $advertId\n";
            $infoResponse = $p2p->getAdvertisementInfo($advertId);
            
            if (isset($infoResponse['error'])) {
                echo "Failed to get advertisement info: " . $infoResponse['error']['message'] . "\n";
            } else {
                echo "Advertisement info retrieved successfully\n";
                echo "Response: " . json_encode($infoResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
        
        // Create advertisement example
        echo "\nCreating new advertisement...\n";
        $createParams = [
            'type' => 'buy', // or 'sell'
            'amount' => 100,
            'max_order_amount' => 1000,
            'min_order_amount' => 10,
            'payment_method' => 'bank_transfer',
            'rate' => 1.05,
            'rate_type' => 'fixed', // or 'float'
        ];
        
        $createResponse = $p2p->createAdvertisement($createParams);
        
        if (isset($createResponse['error'])) {
            echo "Failed to create advertisement: " . $createResponse['error']['message'] . "\n";
        } else {
            echo "Advertisement created successfully\n";
            echo "Response: " . json_encode($createResponse, JSON_PRETTY_PRINT) . "\n";
            
            if (isset($createResponse['p2p_advert_create']['id'])) {
                $newAdvertId = $createResponse['p2p_advert_create']['id'];
                
                // Update advertisement
                echo "\nUpdating advertisement ID: $newAdvertId\n";
                $updateParams = [
                    'max_order_amount' => 2000,
                    'min_order_amount' => 20,
                    'rate' => 1.10
                ];
                
                $updateResponse = $p2p->updateAdvertisement($newAdvertId, $updateParams);
                
                if (isset($updateResponse['error'])) {
                    echo "Failed to update advertisement: " . $updateResponse['error']['message'] . "\n";
                } else {
                    echo "Advertisement updated successfully\n";
                    echo "Response: " . json_encode($updateResponse, JSON_PRETTY_PRINT) . "\n";
                }
                
                // Delete advertisement
                echo "\nDeleting advertisement ID: $newAdvertId\n";
                $deleteResponse = $p2p->deleteAdvertisement($newAdvertId);
                
                if (isset($deleteResponse['error'])) {
                    echo "Failed to delete advertisement: " . $deleteResponse['error']['message'] . "\n";
                } else {
                    echo "Advertisement deleted successfully\n";
                    echo "Response: " . json_encode($deleteResponse, JSON_PRETTY_PRINT) . "\n";
                }
            }
        }
    }
}

function orderOperations(P2P $p2p): void
{
    echo "\n=== Order Operations ===\n";
    
    // Get orders
    echo "Getting orders...\n";
    $params = [
        'limit' => 5,
        'offset' => 0
    ];
    
    $response = $p2p->getOrders($params);
    
    if (isset($response['error'])) {
        echo "Failed to get orders: " . $response['error']['message'] . "\n";
    } else {
        echo "Orders retrieved successfully\n";
        echo "Total orders: " . (isset($response['p2p_order_list']['list']) ? count($response['p2p_order_list']['list']) : 0) . "\n";
        
        // Don't print the full list as it would be too long
        echo "First few orders: " . json_encode(array_slice($response['p2p_order_list']['list'] ?? [], 0, 2), JSON_PRETTY_PRINT) . "\n";
        
        // If we have an order ID, we can use it for other operations
        if (isset($response['p2p_order_list']['list'][0]['id'])) {
            $orderId = $response['p2p_order_list']['list'][0]['id'];
            
            // Get order info
            echo "\nGetting info for order ID: $orderId\n";
            $infoResponse = $p2p->getOrderInfo($orderId);
            
            if (isset($infoResponse['error'])) {
                echo "Failed to get order info: " . $infoResponse['error']['message'] . "\n";
            } else {
                echo "Order info retrieved successfully\n";
                echo "Response: " . json_encode($infoResponse, JSON_PRETTY_PRINT) . "\n";
            }
        }
        
        // Create order example
        echo "\nCreating new order...\n";
        // Assuming we have an advertisement ID from previous operations
        $advertId = isset($response['p2p_order_list']['list'][0]['advert_id']) 
            ? $response['p2p_order_list']['list'][0]['advert_id'] 
            : 12345; // Example ID
            
        $createParams = [
            'advert_id' => $advertId,
            'amount' => 50,
        ];
        
        $createResponse = $p2p->createOrder($createParams);
        
        if (isset($createResponse['error'])) {
            echo "Failed to create order: " . $createResponse['error']['message'] . "\n";
        } else {
            echo "Order created successfully\n";
            echo "Response: " . json_encode($createResponse, JSON_PRETTY_PRINT) . "\n";
            
            if (isset($createResponse['p2p_order_create']['id'])) {
                $newOrderId = $createResponse['p2p_order_create']['id'];
                
                // Confirm order payment
                echo "\nConfirming payment for order ID: $newOrderId\n";
                $confirmResponse = $p2p->confirmOrderPayment($newOrderId);
                
                if (isset($confirmResponse['error'])) {
                    echo "Failed to confirm order payment: " . $confirmResponse['error']['message'] . "\n";
                } else {
                    echo "Order payment confirmed successfully\n";
                    echo "Response: " . json_encode($confirmResponse, JSON_PRETTY_PRINT) . "\n";
                }
                
                // Cancel order (this would normally be done only if needed)
                echo "\nCancelling order ID: $newOrderId\n";
                $cancelResponse = $p2p->cancelOrder($newOrderId);
                
                if (isset($cancelResponse['error'])) {
                    echo "Failed to cancel order: " . $cancelResponse['error']['message'] . "\n";
                } else {
                    echo "Order cancelled successfully\n";
                    echo "Response: " . json_encode($cancelResponse, JSON_PRETTY_PRINT) . "\n";
                }
            }
        }
    }
}

function paymentMethodOperations(P2P $p2p): void
{
    echo "\n=== Payment Method Operations ===\n";
    
    // Get payment methods
    echo "Getting payment methods...\n";
    $response = $p2p->getPaymentMethods();
    
    if (isset($response['error'])) {
        echo "Failed to get payment methods: " . $response['error']['message'] . "\n";
    } else {
        echo "Payment methods retrieved successfully\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function chatOperations(P2P $p2p): void
{
    echo "\n=== Chat Operations ===\n";
    
    // This requires a valid order ID
    // For demonstration purposes, we'll use a placeholder
    $orderId = 12345; // Replace with a valid order ID
    
    // Get chat messages
    echo "Getting chat messages for order ID: $orderId\n";
    $response = $p2p->getChatMessages($orderId);
    
    if (isset($response['error'])) {
        echo "Failed to get chat messages: " . $response['error']['message'] . "\n";
    } else {
        echo "Chat messages retrieved successfully\n";
        echo "Total messages: " . (isset($response['p2p_chat_messages']['list']) ? count($response['p2p_chat_messages']['list']) : 0) . "\n";
        
        // Don't print the full list as it would be too long
        echo "First few messages: " . json_encode(array_slice($response['p2p_chat_messages']['list'] ?? [], 0, 2), JSON_PRETTY_PRINT) . "\n";
    }
    
    // Send chat message
    echo "\nSending chat message for order ID: $orderId\n";
    $message = "Hello, this is a test message.";
    $sendResponse = $p2p->sendChatMessage($orderId, $message);
    
    if (isset($sendResponse['error'])) {
        echo "Failed to send chat message: " . $sendResponse['error']['message'] . "\n";
    } else {
        echo "Chat message sent successfully\n";
        echo "Response: " . json_encode($sendResponse, JSON_PRETTY_PRINT) . "\n";
    }
}