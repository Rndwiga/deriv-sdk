<?php

namespace Rndwiga\DerivApis\Api;

/**
 * Handler for Deriv Utilities APIs
 * @see https://developers.deriv.com/docs/utilities-apis
 */
class Utilities extends BaseApi
{
    /**
     * Ping the server to keep the connection alive
     *
     * @return array
     */
    public function ping()
    {
        return $this->sendRequest([
            'ping' => 1
        ]);
    }

    /**
     * Get server time
     *
     * @return array
     */
    public function getServerTime()
    {
        return $this->sendRequest([
            'time' => 1
        ]);
    }

    /**
     * Get website status
     *
     * @return array
     */
    public function getWebsiteStatus()
    {
        return $this->sendRequest([
            'website_status' => 1
        ]);
    }

    /**
     * Get exchange rates
     *
     * @param string $baseCurrency Base currency
     * @param string|array|null $targetCurrencies List of target currencies (optional)
     * @return array
     */
    public function getExchangeRates($baseCurrency, $targetCurrencies = null)
    {
        $params = [
            'exchange_rates' => 1,
            'include_spread' => 1,
            'base_currency' => $baseCurrency
        ];

        if (!empty($targetCurrencies)) {
            if (is_array($targetCurrencies)) {
                $params['target_currency'] = implode(',', $targetCurrencies);
            } else {
                $params['target_currency'] = $targetCurrencies;
            }
        }

        return $this->sendRequest($params);
    }

    /**
     * Get countries list
     *
     * @return array
     */
    public function getCountriesList()
    {
        return $this->sendRequest([
            'residence_list' => 1
        ]);
    }

    /**
     * Get states list for a country
     *
     * @param string $countryCode Country code
     * @return array
     */
    public function getStatesList($countryCode)
    {
        return $this->sendRequest([
            'states_list' => $countryCode
        ]);
    }

    /**
     * Verify email
     *
     * @param string $email Email address
     * @param string $type Verification type
     * @return array
     */
    public function verifyEmail($email, $type)
    {
        return $this->sendRequest([
            'verify_email' => $email,
            'type' => $type
        ]);
    }

    /**
     * Get app information
     *
     * @param int $appId App ID
     * @return array
     */
    public function getAppInfo($appId)
    {
        return $this->sendRequest([
            'app_get' => $appId
        ]);
    }

    /**
     * Register an app
     *
     * @param array $params App parameters
     * @return array
     */
    public function registerApp(array $params)
    {
        return $this->sendRequest(array_merge(
            ['app_register' => 1],
            $params
        ));
    }

    /**
     * Update an app
     *
     * @param int $appId App ID
     * @param array $params App parameters
     * @return array
     */
    public function updateApp($appId, array $params)
    {
        return $this->sendRequest(array_merge(
            ['app_update' => $appId],
            $params
        ));
    }

    /**
     * Delete an app
     *
     * @param int $appId App ID
     * @return array
     */
    public function deleteApp($appId)
    {
        return $this->sendRequest([
            'app_delete' => $appId
        ]);
    }

    /**
     * List all apps
     *
     * @return array
     */
    public function listApps()
    {
        return $this->sendRequest([
            'app_list' => 1
        ]);
    }

    /**
     * Get API token scopes
     *
     * @return array
     */
    public function getApiTokenScopes()
    {
        return $this->sendRequest([
            'api_token' => 1
        ]);
    }

    /**
     * Create API token
     *
     * @param array $params Token parameters
     * @return array
     */
    public function createApiToken(array $params)
    {
        return $this->sendRequest(array_merge(
            ['api_token' => 1, 'new_token' => 1],
            $params
        ));
    }

    /**
     * Delete API token
     *
     * @param string $token Token to delete
     * @return array
     */
    public function deleteApiToken($token)
    {
        return $this->sendRequest([
            'api_token' => 1,
            'delete_token' => $token
        ]);
    }
}
