<?php

namespace Rndwiga\DerivApis\Api;

use Rndwiga\DerivApis\Client\DerivClient;

/**
 * Base class for all Deriv API handlers
 */
abstract class BaseApi implements ApiInterface
{
    /**
     * @var DerivClient
     */
    protected $client;

    /**
     * BaseApi constructor.
     *
     * @param DerivClient $client
     */
    public function __construct(DerivClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send a request to the API
     *
     * @param array $params Request parameters
     * @return array Response from the API
     */
    public function sendRequest(array $params)
    {
        return $this->client->sendRequest($params);
    }
}