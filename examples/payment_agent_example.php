<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Rndwiga\DerivApis\Api\Account;
use Rndwiga\DerivApis\Api\PaymentAgent;
use Rndwiga\DerivApis\Client\DerivClient;

// Replace with your app ID from Deriv
$appId = 'APP_ID';

// Optional: API token for authenticated requests
$token = 'YOUR_API_TOKEN';

$agentWithdraw = false;
$createPaymentAgent = false;
$transferFromPaymentAgent = false;
$withdrawFromPaymentAgent = false;

// Create a new DerivClient instance
$client = new DerivClient($appId);

//Authenticated Account Access
$authenticatedAccount = new Account($client);

try {
    // Create a new PaymentAgent instance
    $paymentAgent = new PaymentAgent($client);

    // Authenticate with the API (if using authenticated endpoints)
    if ($token) {
        $authResponse = $authenticatedAccount->authorize($token);

        if (isset($authResponse['error'])) {
            echo "Authentication failed: " . $authResponse['error']['message'] . "\n";
            exit;
        }else{
            echo "Authenticated successfully\n";
            echo "Authentication details:".json_encode($authResponse,128). "\n";

            getPaymentAgentList($paymentAgent);
            getPaymentAgentDetails($paymentAgent);
            getAgentWithdrawJustification($paymentAgent,$agentWithdraw);
            createPaymentAgent($paymentAgent,$createPaymentAgent);
            transferPaymentFromAgent($paymentAgent,$transferFromPaymentAgent);
            withdrawViaPaymentAgent($paymentAgent,$withdrawFromPaymentAgent);;
        }

    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    // Always disconnect when done
    $client->disconnect();
    echo "Disconnected from Deriv API\n";
}

function getPaymentAgentList(PaymentAgent $paymentAgent): void
{
    // Example 1: Get payment agent list
    echo "Getting payment agent list...\n";
    $listResponse = $paymentAgent->getPaymentAgents('id', 'USD');

    if (isset($listResponse['error'])) {
        echo "Failed to get payment agent list: " . $listResponse['error']['message'] . "\n";
    } else {
        echo "Payment agent list retrieved successfully\n";
        echo "Payment details:".json_encode($listResponse,128). "\n";
        // Process the response as needed
    }
}

function getAgentWithdrawJustification(PaymentAgent $paymentAgent,$agentWithdraw): void
{
    // Example 3: Get payment agent withdrawal justification
    if ($agentWithdraw){
        echo "Getting withdrawal justification...\n";
        $justificationResponse = $paymentAgent->getWithdrawJustification();

        if (isset($justificationResponse['error'])) {
            echo "Failed to get withdrawal justification: " . $justificationResponse['error']['message'] . "\n";
        } else {
            echo "Withdrawal justification retrieved successfully\n";
            echo "Withdraw justification details:".json_encode($justificationResponse,128). "\n";
        }
    }
}

function createPaymentAgent(PaymentAgent $paymentAgent,$createPaymentAgent): void
{
    // Example 4: Create a payment agent (requires authentication and specific parameters)
    if ($createPaymentAgent) {
        echo "Creating payment agent...\n";
        $createParams = [
            'name' => 'Example Agent',
            'description' => 'Example payment agent description',
            'url' => 'https://example.com',
            'email' => 'agent@example.com',
            'phone' => '+1234567890',
            // Add other required parameters as per API documentation
        ];

        $createResponse = $paymentAgent->createPaymentAgent($createParams);

        if (isset($createResponse['error'])) {
            echo "Failed to create payment agent: " . $createResponse['error']['message'] . "\n";
        } else {
            echo "Payment agent created successfully\n";
            echo "Created payment agent details:".json_encode($createResponse,128). "\n";
            // Process the response as needed
        }
    }
}

function getPaymentAgentDetails(PaymentAgent $paymentAgent): void
{
    // Example 2: Get payment agent details (requires authentication)
    echo "Getting payment agent details...\n";
    $detailsResponse = $paymentAgent->getPaymentAgentDetails();

    if (isset($detailsResponse['error'])) {
        echo "Failed to get payment agent details: " . $detailsResponse['error']['message'] . "\n";
    } else {
        echo "Payment agent details retrieved successfully\n";
        echo "Agent details:".json_encode($detailsResponse,128);
        // Process the response as needed
    }
}

function transferPaymentFromAgent(PaymentAgent $paymentAgent,$transferFromPaymentAgent): void
{
    // Example 5: Payment agent transfer (requires authentication)
    if ($transferFromPaymentAgent) {
        echo "Performing payment agent transfer...\n";
        $transferParams = [
            'amount' => 100,
            'currency' => 'USD',
            'transfer_to' => 'CR12345',
            'description' => 'Example transfer'
        ];

        $transferResponse = $paymentAgent->paymentAgentTransfer($transferParams);

        if (isset($transferResponse['error'])) {
            echo "Failed to perform transfer: " . $transferResponse['error']['message'] . "\n";
        } else {
            echo "Transfer completed successfully\n";
            echo "Transfer details:".json_encode($transferResponse,128). "\n";
            // Process the response as needed
        }
    }
}

function withdrawViaPaymentAgent(PaymentAgent $paymentAgent,$withdrawFromPaymentAgent): void
{
    // Example 6: Payment agent withdrawal (requires authentication)
    if ($withdrawFromPaymentAgent) {
        echo "Performing payment agent withdrawal...\n";
        $withdrawParams = [
            'amount' => 100,
            'currency' => 'USD',
            'paymentagent_loginid' => 'CR12345',
            'verification_code' => '123456',
            'description' => 'Example withdrawal'
        ];

        $withdrawResponse = $paymentAgent->paymentAgentWithdraw($withdrawParams);

        if (isset($withdrawResponse['error'])) {
            echo "Failed to perform withdrawal: " . $withdrawResponse['error']['message'] . "\n";
        } else {
            echo "Withdrawal completed successfully\n";
            echo "Withdrawal details:".json_encode($withdrawResponse,128). "\n";
            // Process the response as needed
        }
    }
}