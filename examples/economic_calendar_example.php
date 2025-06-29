<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Economic Calendar Example
 * 
 * This is an example implementation showing how to use the EconomicCalendar class.
 * Note: The actual Deriv API might not support all the features demonstrated here.
 * Please refer to the official Deriv API documentation for the most up-to-date
 * information on supported endpoints and parameters.
 */

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\EconomicCalendar;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

// Feature flags to enable/disable specific examples
$runGetEconomicCalendar = true;
$runGetEconomicEvent = false;
$runSubscribeEconomicCalendar = false;

// Create a new DerivClient instance
$client = new DerivClient($appId);

// Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new EconomicCalendar instance
    $economicCalendar = new EconomicCalendar($client);

    // Basic economic calendar operations
    if ($runGetEconomicCalendar) {
        getEconomicCalendar($economicCalendar);
    }

    if ($runGetEconomicEvent) {
        getEconomicEvent($economicCalendar);
    }

    if ($runSubscribeEconomicCalendar) {
        subscribeToEconomicCalendar($economicCalendar);
    }

    // Authenticate with the API (if using authenticated endpoints)
    if ($token && $token !== 'YOUR_API_TOKEN') {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
        } else {
            echo "Authenticated successfully\n";
            echo "Authentication details: " . json_encode($authResponse, JSON_PRETTY_PRINT) . "\n";

            // Add any authenticated operations here if needed
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getEconomicCalendar(EconomicCalendar $economicCalendar): void
{
    echo "\n=== Get Economic Calendar Events ===\n";

    // Example with optional filter parameters
    $params = [
        //'end_date' => date('Y-m-d', strtotime('-1 week')), // Events from last week
        //'start_date' => date('Y-m-d', strtotime('+1 week')),   // Events until next week
        'currency' => 'USD'                                       // Limit to 10 events
    ];

    $response = $economicCalendar->getEconomicCalendar($params);

    if (isset($response['error'])) {
        echo "Failed to get economic calendar events: " . $response['error']['message'] . "\n";
    } else {
        echo "Economic calendar events retrieved successfully\n";

        // Check if there are events in the response
        if (isset($response['economic_calendar']) && !empty($response['economic_calendar'])) {
            echo "Total events: " . count($response['economic_calendar']) . "\n";
            echo "First few events: " . json_encode(array_slice($response['economic_calendar'], 0, 3), JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "No economic events found for the specified period.\n";
        }
    }
}

function getEconomicEvent(EconomicCalendar $economicCalendar): void
{
    echo "\n=== Get Economic Event Details ===\n";

    // Replace it with a valid economic event ID
    // Note: You would typically get this ID from the getEconomicCalendar response
    $eventId = 'sample_event_123';

    $response = $economicCalendar->getEconomicEvent($eventId);

    if (isset($response['error'])) {
        echo "Failed to get economic event details: " . $response['error']['message'] . "\n";
    } else {
        echo "Economic event details retrieved successfully\n";
        echo "Event details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    }
}

function subscribeToEconomicCalendar(EconomicCalendar $economicCalendar): void
{
    echo "\n=== Subscribe to Economic Calendar Updates ===\n";

    // Example with optional filter parameters
    $params = [
        'end_date' => date('Y-m-d'), // Events from today
        'start_date' => date('Y-m-d', strtotime('+1 month')), // Events for the next month
    ];

    $response = $economicCalendar->subscribeEconomicCalendar($params);

    if (isset($response['error'])) {
        echo "Failed to subscribe to economic calendar updates: " . $response['error']['message'] . "\n";
    } else {
        echo "Subscribed to economic calendar updates successfully\n";
        echo "Subscription details: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

        // In a real application, you would set up a callback to handle incoming updates
        echo "In a real application, you would now receive real-time updates for economic events.\n";
        echo "For this example, we're just showing the initial subscription response.\n";
    }
}
