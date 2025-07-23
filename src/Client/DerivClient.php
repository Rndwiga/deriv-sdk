<?php

namespace Rndwiga\DerivApis\Client;

use WebSocket\Client;
use WebSocket\Exception;
use WebSocket\Message\Text;

class DerivClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string|null
     */
    private $token;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var int
     */
    private $timeout;

    /**
     * DerivClient constructor.
     * 
     * @param string $appId Your Deriv API app ID
     * @param string|null $token Optional API token for authenticated requests
     * @param string $endpoint WebSocket endpoint URL
     * @param int $timeout Connection timeout in seconds
     */
    public function __construct(
        $appId,
        $token = null,
        $endpoint = 'wss://ws.derivws.com/websockets/v3',
        $timeout = 60
    ) {
        $this->appId = $appId;
        $this->token = $token;
        $this->endpoint = $endpoint;
        $this->timeout = $timeout;
        $this->connect();
        //
    }

    /**
     * Set or update the authentication token
     *
     * @param string|null $token API token for authenticated requests
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get the current token
     *
     * @return string|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Check if a token is currently set
     *
     * @return bool
     */
    public function hasToken()
    {
        return !empty($this->token);
    }


    /**
     * Connect to the WebSocket server
     * 
     * @return void
     */
    private function connect()
    {
        // Create client if it doesn't exist
        if (!$this->client) {
            $this->client = new Client("$this->endpoint?app_id=$this->appId");
            $this->client->setTimeout($this->timeout);
        }

        // Connect if not already connected
        if (!$this->client->isConnected()) {
            $this->client->connect();
        }
    }

    /**
     * Send a request to the Deriv API
     * 
     * @param array $request The request payload
     * @return array The response from the API
     * @throws Exception
     */
    public function sendRequest(array $request)
    {
        // Add app_id to all requests
        //$request['app_id'] = $this->appId;

        // Add authorization token if available
        if ($this->token) {
            $request['authorize'] = $this->token;
        }

        // Check if connected, if not, connect
        if (!$this->client->isConnected()) {
            $this->connect();
        }

        // Send message using the text convenience method
        $this->client->text(json_encode($request));

        // Receive response with timeout
        $response = $this->client->receive();

        // Return decoded response if received
        if ($response) {
            return json_decode($response->getContent(), true);
        }

        // Return error if no response received
        return ['error' => ['message' => 'No response received from server']];
    }

    /**
     * Close the WebSocket connection
     * 
     * @param int $status Optional status code
     * @param string $message Optional close message
     * @return void
     */
    public function disconnect(int $status = 1000, string $message = 'ttfn')
    {
        if ($this->client && $this->client->isConnected()) {
            $this->client->close($status, $message);
            $this->client->disconnect();
        }
    }
}
