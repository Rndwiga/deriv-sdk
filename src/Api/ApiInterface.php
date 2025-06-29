<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Interface for all Deriv API handlers
 */
interface ApiInterface
{
    /**
     * Send a request to the API
     *
     * @param array $params Request parameters
     * @return array Response from the API
     */
    public function sendRequest(array $params);
}